<?php

get_header();
if (is_services_dinamic())
    get_template_part("_services_dinamic");
else
    get_template_part("_services_normal_single");
get_footer();
