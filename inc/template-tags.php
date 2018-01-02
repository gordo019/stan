<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package StrapPress
 */

if ( ! function_exists( 'strappress_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function strappress_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'strappress' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'strappress' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>
	<span class="byline">' . $byline . '</span>'; // WPCS: XSS OK.

	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'strappress' ) );
		if ( $categories_list && strappress_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'strappress' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'strappress' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

}
endif;

if ( ! function_exists( 'strappress_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function strappress_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'strappress' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( '%1$s', 'strappress' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'strappress' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link float-right">',
		'</span>', 0, 'btn btn-sm btn-danger'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function strappress_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'strappress_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'strappress_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so strappress_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so strappress_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in strappress_categorized_blog.
 */
function strappress_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'strappress_categories' );
}
add_action( 'edit_category', 'strappress_category_transient_flusher' );
add_action( 'save_post',     'strappress_category_transient_flusher' );

if (function_exists("fellowtuts_wpbs4_pagination"))
{
    fellowtuts_wpbs4_pagination();
    //fellowtuts_wpbs_pagination($the_query->max_num_pages);
}


function fellowtuts_wpbs4_pagination($pages = '', $range = 2) 
{  
	$showitems = ($range * 2) + 1;  
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == '')
	{
		global $wp_query; 
		$pages = $wp_query->max_num_pages;
	
		if(!$pages)
			$pages = 1;		 
	}   
	
	if(1 != $pages)
	{
	    echo '<nav aria-label="Page navigation" role="navigation">';
        echo '<span class="sr-only">Page navigation</span>';
        echo '<ul class="pagination justify-content-start ft-wpbs">';
		
        echo '<li class="page-item disabled d-none d-lg-block"><span class="page-link">Page '.$paged.' of '.$pages.'</span></li>';
	
	 	if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
			echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link(1).'" aria-label="First Page">&laquo;<span class="d-none d-md-block"></span></a></li>';
	
	 	if($paged > 1 && $showitems < $pages) 
			echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($paged - 1).'" aria-label="Previous Page">&lsaquo;<span class="d-none d-md-block"></span></a></li>';
	
		for ($i=1; $i <= $pages; $i++)
		{
		    if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				echo ($paged == $i)? '<li class="page-item active"><span class="page-link"><span class="sr-only">Current Page </span>'.$i.'</span></li>' : '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($i).'"><span class="sr-only">Page </span>'.$i.'</a></li>';
		}
		
		if ($paged < $pages && $showitems < $pages) 
			echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($paged + 1).'" aria-label="Next Page"><span class="d-none d-md-block"></span>&rsaquo;</a></li>';  
	
	 	if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) 
			echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($pages).'" aria-label="Last Page"><span class="d-none d-md-block"></span>&raquo;</a></li>';
	
	 	echo '</ul>';
        echo '</nav>';
        //echo '<div class="pagination-info mb-5 text-center">[ <span class="text-muted">Page</span> '.$paged.' <span class="text-muted">of</span> '.$pages.' ]</div>';	 	
	}
}
