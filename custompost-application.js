/* 
 *Custom post and taxonomy creator Plugins
 *Author: Sourav Mondal
 *Version : 1.0.0
 */
jQuery(document).ready(function($) {
    /* on ready  */
    var currently_selected = $("#main_action").val();
    if (currently_selected == "post") {
        $("#create_custom_post").slideDown(600);
        $("#create_custom_taxonomy").hide("slow");
    } else if (currently_selected == "taxonomy") {
        $("#create_custom_post").hide("slow");
        $("#create_custom_taxonomy").slideDown(600);
    } else {
        $("#create_custom_post").hide("slow");
        $("#create_custom_taxonomy").hide("slow");
    }
    /* on change action of dropdown */
    $("#main_action").change(function() {
        var selected_action = $(this).val();
        if (selected_action != "") {
            if (selected_action == "post") {
                $("#create_custom_post").slideDown(600);
                $("#create_custom_taxonomy").hide("slow");
            } else if (selected_action == "taxonomy") {
                $("#create_custom_post").hide("slow");
                $("#create_custom_taxonomy").slideDown(600);
            }
        } else {
            $("#create_custom_post").hide("slow");
            $("#create_custom_taxonomy").hide("slow");
        }
    });
});


    