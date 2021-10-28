@section('script')
    <script type="text/javascript">
    $(document).ready(() => {
        el=$('input[name="is_translatable"]');
        el.on('switchChange.bootstrapSwitch', function (event, state) {
            fnToggleLanguageSpecific(state);
        });
        fnInitLanguageSpecific(el);
    });

    fnToggleLanguageSpecific = function(state)
    {
        if (state)
        {
            $("#div_wrap_value").hide();
            $(".div_wrap_translated_value").show();
        }
        else
        {
            $("#div_wrap_value").show();
            $(".div_wrap_translated_value").hide();
        }
    }

    fnInitLanguageSpecific = function(el)
    {
        fnToggleLanguageSpecific(el.bootstrapSwitch('state'));
    }
    </script>
@append

@extends('user.form')
