<?php

function nb_get_page_template() {
    $rows = get_field("rows");
    if ($rows) {
        foreach ($rows as $place => $row) {
            nb_get_page_view($row, $place);
        }
    }
}

function nb_get_page_view($row, $place) {
    $template_name = "_view_" . str_replace(" ", "_", $row["type"]);
    $template_folder = str_replace(".php", "", get_page_template_slug());
    $GLOBALS["template_row"] = [
        "place" => $place,
        "data" => $row,
    ];
    get_template_part($template_folder . "/" . $template_name);
}

function nb_get_page_row_data() {
    return (object) $GLOBALS["template_row"];
}

function nb_get_post_type_items($row) {
    if ($row["order"] == "newest")
        $order = "desc";
    else
        $order = "asc";

    return nb_posts_by($row["choose_post_type"], $row["limit"], $order);
}


function get_view_button($template_name = '_view_button') {
    $template_folder = str_replace(".php", "", get_page_template_slug());
    get_template_part($template_folder . "/" . $template_name);
}
