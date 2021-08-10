let
        s_page_route        = '{!! $s_page_route !!}'
        ,s_res_submit       = '{!! trans( $s_category . '::crud.names.saved') . ' ' . mb_strtolower(trans( 'user/messages.text.'.($o_item->id ? 'updated' : 'created')) ) !!}'
        ,s_text_extra       = '{!! $s_btn_extra !!}'
        ,s_route_extra      = '{!! $s_route_extra !!}'
        ,s_text_primary     = '{!! $s_btn_primary !!}'
        ,s_route_primary    = '{!! $s_route_primary !!}'
        ,s_text_secondary   = '{!! $s_btn_secondary !!}'
        ,s_route_secondary  = '{!! $s_route_secondary !!}'
        ,s_close_route      = '{!! $s_cancel_route !!}'
        ,s_action_form      = '{!! ($o_item->id ? 'update' : 'create') !!}'
        ;

