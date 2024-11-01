<?php
/*
 * Admin interface to create custom post types and taxonomies
 */
/** defining global */
global $wpdb;
/** getting the list of registered post types */
$all_post_types = get_post_types('', 'names');
/** removing default post types */
unset($all_post_types['attachment']);
unset($all_post_types['revision']);
unset($all_post_types['nav_menu_item']);
/** extracting keys for better manipulation */
$post_types = array_keys($all_post_types);

function clean($string) {
    $string = str_replace(" ", "-", $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
}

function is_post_type_exists($post_type_name) {
    if (array_key_exists($post_type_name, $all_post_types)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function is_taxonomy_exists($taxonomy_name) {
    $all_registered_taxonomies = get_taxonomies('', 'names');
    print_r($all_registered_taxonomies);
    if (array_key_exists($taxonomy_name, $all_registered_taxonomies)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

if (isset($_POST['customflag'])) {
    if ($_POST['customflag'] == "createpost") {
        $post_type_name = clean(trim($_POST['name_post']));
        $menu_label = clean(trim($_POST['postlabel']));
        $post_type_description = clean(trim($_POST['description']));
        $hierarchical = clean(trim($_POST['hierarchical']));
        if (!is_post_type_exists($post_type_name)) {
            $sql_insert_post_type = "INSERT INTO 
            " . $wpdb->prefix . "custom_post_types 
                (name,label,description,hierarchical)
                VALUES ('$post_type_name','$menu_label','$post_type_description','$hierarchical')";
            $wpdb->query($sql_insert_post_type);
            $msg = "Custom post type Created " . $post_type_name . " .Refresh the page to use that";
            wp_reset_query();
            $wpdb->flush();
        } else {
            $msg = "Post Type Already Exists.Try a Different name.";
        }
    } elseif ($_POST['customflag'] == "createtaxonomy") {
        $custom_taxonomy_slug = clean(trim($_POST['slug']));
        $hierarchical = clean(trim($_POST['hierarchical']));
        $taxonomylabel = clean(trim($_POST['taxonomylabel']));
        $post_type_related = clean(trim($_POST['posttype']));
        if (!is_taxonomy_exists($taxonomy_name)) {
            $sql_insert_custom_taxonomy = "INSERT INTO 
            " . $wpdb->prefix . "custom_taxonomy_types 
                (slug,label,hierarchical,post_type) VALUES 
                ('$custom_taxonomy_slug','$taxonomylabel','$hierarchical','$post_type_related')";
            $wpdb->query($sql_insert_custom_taxonomy);
            $msg = "Taxonomy Created " . $custom_taxonomy_slug . " .Refresh the page to use that";
            wp_reset_query();
            $wpdb->flush();
        } else {
            $msg = "Taxonomy Already Registered.Try a Different name.";
        }
    }
}
?>
<div id="main_container_cptp">
    <h2>Choose What you want</h2>
    <div class="msg"><?php
        if (isset($msg)) {
            echo $msg;
        }
        ?></div>
    <select name="main_action" id="main_action">
        <option value="">---Select---</option>
        <option value="post" <?php
        if (isset($_POST) && $_POST['main_action'] == "post") {
            echo "selected='selected'";
        }
        ?>>Create Custom Post Type</option>
        <option value="taxonomy" <?php
        if (isset($_POST) && $_POST['main_action'] == "taxonomy") {
            echo "selected='selected'";
        }
        ?>>Create Custom Taxonomy</option>
    </select>
    <div id="create_custom_post" class="create_custom_post">
        <h3>Create Custom Post type:</h3>
        <hr/>
        <h3>Provide necessary Details Bellow:</h3>
        <form name="custompost_create_form" id="custompost_create_form" method="post" action="#">
            <table>
                <tr bgcolor='#C2D7DE'>
                    <td>
                        <label>Name of the post type *</label>
                    </td>
                    <td>
                        <input type="text" name="name_post" id="name_post" required="required" maxlength="50"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Menu label *</label>
                    </td>
                    <td>
                        <input type='text' name="postlabel" id="postlabel" required="required" maxlength="50"/>
                    </td>
                </tr>
                <tr bgcolor='#C2D7DE'>
                    <td>
                        <label>Small Description *</label>
                    </td>
                    <td>
                        <input type='text' name="description" id="description" required="required" maxlength="150"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Follow hierarchical Structure(If you don't know,leave it with default value) *</label>
                    </td>
                    <td>
                        <select name='hierarchical' id='hierarchical'>
                            <option value='true' selected="selected">Yes</option>
                            <option value='false'>No</option>
                        </select>
                    </td>
                </tr>
                <tr bgcolor='#C2D7DE'>
                    <td colspan="2">
                        <input type="hidden" name="customflag" id="customflag" value="createpost"/>
                        <input type="hidden" name="main_action" value="post"/>
                        <input type="submit" id="create_post_submit" name="create_post_submit" value="Create"/>
                        <label>( All * marked fields are necessary )</label>
                    </td>
                </tr>

            </table>
        </form>
    </div>

    <div id="create_custom_taxonomy" class="create_custom_taxonomy">
        <h3>Create Custom Taxonomy:</h3>
        <hr/>
        <h3>Provide necessary Details Bellow:</h3>
        <form name="custompost_create_form" id="custompost_create_form" method="post" action="#">
            <table>
                <tr bgcolor='#C2D7DE'>
                    <td>
                        <label>Taxonomy Name </label>
                    </td>
                    <td>
                        <input type="text" name='slug' id='slug' required="required"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Follow hierarchical Structure(If you don't know,leave it with default value) *</label>
                    </td>
                    <td>
                        <select name='hierarchical' id='hierarchical'>
                            <option value='true'>Yes</option>
                            <option value='false'>No</option>
                        </select>
                    </td>
                </tr>
                <tr bgcolor='#C2D7DE'>
                    <td>
                        <label>Menu label *</label>
                    </td>
                    <td>
                        <input type='text' name="taxonomylabel" id="taxonomylabel" required="required" maxlength="50"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Associate With *</label>
                    </td>
                    <td>
                        <select name='posttype' id='posttype'>
                            <?php
                            foreach ($post_types as $single_post_type) {
                                ?>
                                <option value='<?php echo $single_post_type; ?>'><?php echo $single_post_type; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr bgcolor='#C2D7DE'>
                    <td colspan="2">
                        <input type="hidden" name="customflag" id="customflag" value="createtaxonomy"/>
                        <input type="hidden" name="main_action" value="taxonomy"/>
                        <input type="submit" id="create_post_submit" name="create_post_submit" value="Create"/>
                        <label>( All * marked fields are necessary )</label>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<br class="clear"/>
<span class="authinfo">This Plugin is created by <a href="http://souravmondal.co.in" target="_blank">Sourav Mondal</a></span>
<br class="clear"/>
<span class="authinfo">Contact Developer @ <a href="mailto:souravmondal10@gmail.com" target="_blank">souravmondal10@gmail.com</a></span>