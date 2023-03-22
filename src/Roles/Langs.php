<?php

namespace Framework\Roles;

class Langs {

	private $langs = [], $postTypes = [], $taxonomies = [];

	public function __construct() {
		add_action( 'admin_init', [ $this, 'setActionsForUser' ] );
	}

	/* ---
	  Functions
	--- */

	public function setActionsForUser() {
		if ( ( ! $user = wp_get_current_user() ) || ! $user->roles
			|| ! function_exists( 'get_field' ) || ( ! $roles = get_field( 'wpf_roles', 'options' ) ) ) {
			return;
		}

		foreach ( $roles as $role ) {
			if ( ! in_array( 'wpf_' . $role['role_name'], $user->roles )
				|| ( ! $langs = $role['wpf_roles_langs'] ?? [] ) ) {
				continue;
			}

			$this->langs      = array_merge( $this->langs, $langs );
			$this->postTypes  = array_merge( $this->postTypes, array_column( $role['wpf_roles_posttypes'], 'wpf_roles_posttype' ) );
			$this->taxonomies = array_merge( $this->taxonomies, array_column( $role['wpf_roles_taxonomies'], 'wpf_roles_taxonomy' ) );
		}
		if ( ! $this->langs ) {
			return;
		}

		add_action( 'wp_insert_post_data', [ $this, 'disablePostUpdate' ], 100, 2 );
		add_action( 'acf/save_post', [ $this, 'disablOptionsPageUpdate' ], 0 );
		add_action( 'pre_insert_term', [ $this, 'disableTermPublish' ], 0, 2 );
		add_action( 'edit_terms', [ $this, 'disableTermUpdate' ], 0, 2 );

		foreach ( $this->postTypes as $postType ) {
			add_filter( 'bulk_actions-edit-' . $postType, [ $this, 'removeBulkActions' ], 100 );
			add_filter( 'manage_edit-' . $postType . '_columns', [ $this, 'removeColumns' ], 100 );
		}
		foreach ( $this->taxonomies as $taxonomy ) {
			add_filter( 'bulk_actions-edit-' . $taxonomy, [ $this, 'removeBulkActions' ], 100 );
			add_filter( 'manage_edit-' . $taxonomy . '_columns', [ $this, 'removeColumns' ], 100 );
			add_filter( $taxonomy . '_row_actions', [ $this, 'removeInlineActions' ], 100, 2 );
		}

		add_filter( 'post_row_actions', [ $this, 'removeInlineActions' ], 100, 2 );
		add_filter( 'page_row_actions', [ $this, 'removeInlineActions' ], 100, 2 );

		add_filter( 'get_edit_post_link', [ $this, 'resetEditLinkForPost' ], 100, 2 );
		add_filter( 'get_edit_term_link', [ $this, 'resetEditLinkForTerm' ], 100, 3 );
	}

	public function disablePostUpdate( $data, $postarr ) {
		if ( ( ! $lang = pll_get_post_language( $postarr['ID'] ) )
			|| in_array( $lang, $this->langs ) ) {
			return $data;
		}

		wp_die( sprintf( __( 'Sorry, you are not allowed to perform this action. %s%sGo back.%s', 'wpf' ),
			'<br>',
			'<a href="' . admin_url( 'edit.php?post_type=' . $postarr['post_type'] ) . '">',
			'</a>'
		) );
	}

	public function disablOptionsPageUpdate( $postId ) {
		if ( ! isset( $_GET['page'] ) || ( $postId === 'options' )
			|| ( ! $lang = pll_current_language() )
			|| in_array( $lang, $this->langs ) ) {
			return;
		}

		wp_die( sprintf( __( 'Sorry, you are not allowed to perform this action. %s%sGo back.%s', 'wpf' ),
			'<br>',
			'<a href="' . admin_url( 'admin.php?page=' . $_GET['page'] ) . '">',
			'</a>'
		) );
	}

	public function disableTermPublish( $term, $taxonomy ) {
		if ( ( ! $lang = get_term_by( 'id', $_POST['term_lang_choice'] ?? -1, 'language' ) )
			|| in_array( $lang->slug, $this->langs ) ) {
			return $term;
		}

		return new WP_Error( 'not_allowed', __( 'Sorry, you are not allowed to perform this action.', 'wpf' ) );
	}

	public function disableTermUpdate( $termId, $taxonomy ) {
		if ( ( ! $lang = pll_get_term_language( $termId ) )
			|| in_array( $lang, $this->langs ) ) {
			return $termId;
		}

		wp_die( sprintf( __( 'Sorry, you are not allowed to perform this action. %s%sGo back.%s', 'wpf' ),
			'<br>',
			'<a href="' . admin_url( 'term.php?taxonomy=' . $taxonomy ) . '">',
			'</a>'
		) );
	}

	public function removeBulkActions( $actions ) {
		if ( ( ! $lang = pll_current_language() )
			|| in_array( $lang, $this->langs ) ) {
			return $actions;
		}

		return [];
	}

	public function removeColumns( $columns ) {
		foreach ( $columns as $column => $title ) {
			if ( ( strpos( $column, 'language_' ) !== 0 )
				|| ( ! $lang = str_replace( 'language_', '', $column ) )
				|| in_array( $lang, $this->langs ) ) {
				continue;
			}
			unset( $columns[ $column ] );
		}
		return $columns;
	}

	public function removeInlineActions( $actions, $post ) {
		if ( ( ! $lang = pll_get_post_language( $post->ID ) )
			|| in_array( $lang, $this->langs ) ) {
			return $actions;
		}

		if ( isset( $actions['view'] ) ) {
			return array_merge( [], [ 'view' => $actions['view'] ] );
		} else {
			return [];
		}
	}

	public function resetEditLinkForPost( $link, $postId ) {
		if ( ( ! $lang = pll_get_post_language( $postId ) )
			|| in_array( $lang, $this->langs ) ) {
			return $link;
		}

		return '#';
	}

	public function resetEditLinkForTerm( $link, $termId, $taxonomy ) {
		if ( ( ! $lang = pll_get_term_language( $termId ) )
			|| in_array( $lang, $this->langs ) ) {
			return $link;
		}

		return '';
	}
}
