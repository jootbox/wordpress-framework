<?php

namespace Framework\Roles;

class Add {
	/* ---
	  Functions
	--- */

	public function addUserRole( $role ) {
		$caps = apply_filters( 'wpf_filter_data',
			'wpf_role_caps', $this->getCapsForRole( $role ), [ $role['role_name'] ] );

		$result = add_role(
			'wpf_' . $role['role_name'],
			$role['display_name'],
			$caps
		);
	}

	private function getCapsForRole( $role ) {
		return array_merge(
			[
				'delete_post' => true,
				'edit_post'   => true,
				'read'        => true,
				'read_post'   => true,
			],
			$this->getCapsForPosttypes( $role ),
			$this->getCapsForTaxonomies( $role ),
			$this->getCapsForOptionssubpages( $role ),
			$this->getCapsForCustom( $role )
		);
	}

	private function getCapsForPosttypes( $role ) {
		$caps      = [];
		$posttypes = $role['wpf_roles_posttypes'];
		if ( ! $posttypes ) {
			return $caps;
		}

		foreach ( $posttypes as $posttype ) {
			$slug = $posttype['wpf_roles_posttype'];
			if ( $slug === 'post' ) {
				$slug = 'posts';
			} elseif ( $slug === 'page' ) {
				$slug = 'pages';
			}

			$postIds = preg_replace( '/\s+/', '', $posttype['selected_ids'] ?: '' );
			$capsKey = 'capabilities_' . ( ( $slug === 'attachment' ) ? 'attachment' : 'post' );
			foreach ( $posttype[ $capsKey ] as $cap ) {
				if ( $postIds && ( $cap !== 'edit_%s' ) ) {
					continue;
				}
				$key          = sprintf( $cap, $slug );
				$caps[ $key ] = true;
			}

			if ( $postIds ) {
				foreach ( explode( ',', $postIds ) as $postId ) {
					$key          = sprintf( 'access_%s_%s', $posttype['wpf_roles_posttype'], $postId );
					$caps[ $key ] = true;
				}
			}
		}

		return $caps;
	}

	private function getCapsForTaxonomies( $role ) {
		$caps       = [];
		$taxonomies = $role['wpf_roles_taxonomies'];
		if ( ! $taxonomies ) {
			return $caps;
		}

		foreach ( $taxonomies as $taxonomy ) {
			$slug = $taxonomy['wpf_roles_taxonomy'];

			$capsKey = 'capabilities_' . ( ( $slug === 'category / post_tag' ) ? 'category' : 'taxonomy' );
			foreach ( $taxonomy[ $capsKey ] as $cap ) {
				$key          = sprintf( $cap, $slug );
				$caps[ $key ] = true;
			}
		}

		return $caps;
	}

	private function getCapsForOptionssubpages( $role ) {
		$caps     = [];
		$subpages = $role['wpf_roles_optionspages'];
		if ( ! $subpages ) {
			return $caps;
		}

		foreach ( $subpages as $subpage ) {
			$key          = sprintf( 'options_subpage_%s', $subpage );
			$caps[ $key ] = true;
		}

		return $caps;
	}

	private function getCapsForCustom( $role ) {
		$caps    = [];
		$customs = $role['wpf_roles_custom'];
		if ( ! $customs ) {
			return $caps;
		}

		foreach ( $customs as $custom ) {
			$caps[ $custom ] = true;
		}

		return $caps;
	}
}
