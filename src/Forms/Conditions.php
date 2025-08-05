<?php

namespace Framework\Forms;

class Conditions
{
    /* ---
      Generate form
    --- */

    public function printConditions($content, $formId)
    {
        $conditions = $this->generateConditions($formId);
        if (!$conditions) {
            return $content;
        }

        foreach ($conditions as $name => $rules) {
            $content = str_replace(
                'v-hide="[condition=' . $name . ']"',
                'v-show="!' . $rules . '"',
                $content
            );
            $content = str_replace(
                '[condition=' . $name . ']',
                $rules,
                $content
            );
        }

        return $content;
    }

    private function generateConditions($formId)
    {
        $list = get_field('conditions', $formId);
        $items = [];
        if (!$list) {
            return $items;
        }

        foreach ($list as $item) {
            $groups = [];
            foreach ($item['groups'] as $group) {
                $conditions = [];
                foreach ($group['list'] as $condition) {
                    $conditions[] = $this->printCondition($condition);
                }
                $glue = ($group['relation'] === 'or') ? ' || ' : ' && ';
                $groups[] = '(' . implode($glue, $conditions) . ')';
            }
            $items[$item['name']] = '(' . implode(' && ', $groups) . ')';
        }

        return $items;
    }

    private function printCondition($condition)
    {
        return match ($condition['operator']) {
            '==' => "(form.{$condition['field']} == '{$condition['value']}')",
            '!=' => "(form.{$condition['field']} != '{$condition['value']}')",
            '<' => "(form.{$condition['field']} < '{$condition['value']}')",
            '>' => "(form.{$condition['field']} > '{$condition['value']}')",
            'contains' => "(Array.isArray(form.{$condition['field']}) && (form.{$condition['field']}.indexOf('{$condition['value']}') > -1))",
            'not_contains' => "(!Array.isArray(form.{$condition['field']}) || (form.{$condition['field']}.indexOf('{$condition['value']}') === -1))",
            'empty' => "((form.{$condition['field']} === '') || (Array.isArray(form.{$condition['field']}) && (form.{$condition['field']}.length === 0)))",
            'not_empty' => "((!Array.isArray(form.{$condition['field']}) && (form.{$condition['field']} !== '')) || (Array.isArray(form.{$condition['field']}) && (form.{$condition['field']}.length > 0)))",
            default => false,
        };
    }

    /* ---
      Detect in back-end
    --- */

    public function detectConditions($formId, $params)
    {
        $list = get_field('conditions', $formId);
        $items = [];
        if (!$list) {
            return $items;
        }

        foreach ($list as $item) {
            $status = false;
            foreach ($item['groups'] as $group) {
                $status = $this->detectConditionsGroup($group['list'], $group['relation'], $params);
                if (!$status) {
                    break;
                }
            }
            $items[$item['name']] = $status;
        }

        return $items;
    }

    private function detectConditionsGroup($list, $relation, $params)
    {
        $status = false;
        foreach ($list as $rule) {
            $key = $rule['field'];
            if (!isset($params[$key]) || !$this->detectRule($rule, $params[$key])) {
                if ($relation === 'and') {
                    return;
                } else {
                    continue;
                }
            } else {
                $status = true;
            }
        }

        return $status;
    }

    private function detectRule($rule, $value)
    {
        return match ($rule['operator']) {
            '==' => ($value == $rule['value']),
            '!=' => ($value != $rule['value']),
            '<' => ($value < $rule['value']),
            '>' => ($value > $rule['value']),
            'contains' => (is_array($value) && in_array($rule['value'], $value)),
            'not_contains' => (!is_array($value) || !in_array($rule['value'], $value)),
            'empty' => (($value === '') || (is_array($value) && (count($value) === 0))),
            'not_empty' => ((!is_array($value) && ($value !== '')) || (is_array($value) && (count($value) > 0))),
            default => false,
        };
    }
}
