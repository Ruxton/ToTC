<?php
/*
Plugin Name:	Think of The Children
Plugin URI:		http://ignite.digitalignition.net/articlesexamples/think-of-the-children-table-of-contents-plugin/
Description:	Shortcodes for a table of contents based on child pages
Author:			Greg Tangey
Author URI:		http://ignite.digitalignition.net/
Version:		0.2.0
*/

/*  Copyright 2009  Greg Tangey  (email : greg@digitalignition.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once(dirname(__FILE__).'/totc.base.php');

function totc_children( $atts )
{
	global $post;
	global $more;
	$more = 0;
	$return = "";

  $oldpost = $post;

	if($post->ID)
	{
		$args = array (
			'post_parent' => $post->ID,
			'post_type' => 'page',
			'orderby' => 'date',
			'order' => 'DESC',
		);
		$children = get_posts($args);

		if ($children) {
			foreach ($children as $post) {
				setup_postdata($post);
				$more = 0;
				$content = get_the_content('');
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);

				$return .= '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>
'.$content;
			}
		}

	}
  setup_postdata($oldpost);
	return $return;
}

function totc_parent( $atts )
{
	global $post;

	extract( shortcode_atts( array (
			'text' => 'Return to Parent Article'
		), $atts ) );

	if($post->post_parent)
	{
		$args = array(
			'page_id' => $post->post_parent,
			'post_type' => 'page',
			'orderby' => 'date',
			'order' => 'DESC',
			'numberposts' => 1
		);

		$parent = get_posts($args);
		$link = get_permalink($parent[0]->ID);

		$return = '<p><a href="'.$link.'">Return to Parent Page</a></p>';

	}
	else
	{
		$return = "";
	}

	return $return;

}

add_shortcode('totc_children', 'totc_children');
add_shortcode('totc_parent', 'totc_parent');
?>
