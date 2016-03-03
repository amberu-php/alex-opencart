<?php
/******************************************************
 * @package Tags PAV blog module for Opencart 2.0.x
 * @version 1.0
 * @author https://krumax.info
 * @copyright	Copyright (C) Nov 2015 krumax.info <@emai:mrkrumax@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ModelPavblogTags
 */
class ModelPavblogTags extends Model {

	public function getTags($id){
		$query = 'SELECT bd.lang_tags as lang_tags FROM '. DB_PREFIX . 'pavblog_blog_description bd 
		LEFT JOIN '. DB_PREFIX . 'pavblog_blog b ON bd.blog_id = b.blog_id
		WHERE bd.language_id='.(int)$this->config->get('config_language_id').' AND b.category_id='.(int)$id;

		$query = $this->db->query($query);
		$lang_tags = array();

		foreach($query->rows as $row){
			if($row['lang_tags'] != ''){

				$lang_tags = array_merge($lang_tags, explode(", ", $row['lang_tags']));
			}
		}
		return array_unique($lang_tags);
	}


	public function getAllTags(){
		$query = 'SELECT lang_tags  FROM '. DB_PREFIX . 'pavblog_blog_description WHERE language_id='.(int)$this->config->get('config_language_id');

		$query = $this->db->query($query);
		$lang_tags = array();

		foreach($query->rows as $row){
			if($row['lang_tags'] != ''){

				$lang_tags = array_merge($lang_tags, explode(", ", $row['lang_tags']));
			}
		}
		return array_unique($lang_tags);
	}

}
?>
