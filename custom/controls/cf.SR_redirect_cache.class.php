<?php
if(!class_exists('free_SR_redirect_cache')){
    class free_SR_redirect_cache {

        /*- Add Redirect ----------------------------------------*/
        public function add_redirect($post_id,$is_redirected,$redirect_to,$redirect_type=301)
        {
            global $wpdb,$table_prefix;
            $table_name = $table_prefix . 'WP_SEO_Cache';
            $wpdb->query(" insert IGNORE into $table_name(ID,is_redirected,redirect_to,redirect_type) values('$post_id','$is_redirected','$redirect_to','$redirect_type'); ");
        }

        /*- Fetch Redirect ----------------------------------------*/
        public function fetch_redirect($post_id)
        {
            global $wpdb,$table_prefix;
            $table_name = $table_prefix . 'WP_SEO_Cache';
            return $wpdb->get_row("select *  from  $table_name where ID='$post_id'; ");
        }

        /*- Redirect Cache ----------------------------------------*/
        public function redirect_cached($post_id)
        {
            $redirect = $this->fetch_redirect($post_id);
            $source = get_permalink($post_id); 
            
            if($redirect != null && $redirect->redirect_to!=$source)
            {                
                echo $redirect->redirect_to . '-' . $source;
                exit(0);
                
                if($redirect->is_redirected==1)
                {
                    if($redirect->redirect_type==301)
                    {
                        header ('HTTP/1.1 301 Moved Permanently');
                        header ("Location: " . $redirect->redirect_to);
                        exit();
                    }
                    else if($redirect->redirect_type==307)
                    {
                        header ('HTTP/1.0 307 Temporary Redirect');
                        header ("Location: " . $redirect->redirect_to);
                        exit();
                    }
                    else if($redirect->redirect_type==302)
                    {
                        header ("Location: " . $redirect->redirect_to);
                        exit();
                    }
                }
                return 'not_redirected';
            }
            return 'not_found';
            
        }

        /*- Delete Redirect ----------------------------------------*/
        public function del_redirect($post_id)
        {
            global $wpdb,$table_prefix;
            $table_name = $table_prefix . 'WP_SEO_Cache';
            return $wpdb->get_var("delete from  $table_name where ID='$post_id'; ");
        }

        /*- Free Cache ----------------------------------------*/
        public function free_cache()
        {
            global $wpdb,$table_prefix;
            $table_name = $table_prefix . 'WP_SEO_Cache';
            $wpdb->query(" TRUNCATE TABLE  $table_name ");
        }

        /*- Cache Count ----------------------------------------*/
        public function count_cache()
        {
            global $wpdb,$table_prefix;
            $table_name = $table_prefix . 'WP_SEO_Cache';
            return $wpdb->get_var("select count(*) as cnt from  $table_name where 1;  ");
        }
        
        /* ----------------------------------------------- */
        public static function hook_cache()
        {
            add_action( 'save_post', array( __CLASS__, 'free_cache' ) );            
        }

    }}