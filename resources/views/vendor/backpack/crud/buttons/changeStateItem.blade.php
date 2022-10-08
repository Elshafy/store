<a href="javascript:void(0)" onclick="change(this)"
    data-route="{{ url($crud->route . '/' . $entry->getKey() . '/changeState') }}"
    class="btn btn-sm btn-link text-capitalize" data-button-type="change"
    data-mes-success='@if ($entry->active) {{ trans('item.inactive') }} @else {{ trans('item.active') }} @endif'
    data-mes-error="{{ trans('item.error') }}">
    <i class="la la-question"></i>
    @if ($entry->active)
        {{ trans('item.inactive') }}
    @else
        {{ trans('item.active') }}
    @endif


</a>



<script>
    if (typeof change != 'function') {
        $("[data-button-type=change]").unbind('click');

        function change(button) {
            // ask for confirmation before deleting an item
            // e.preventDefault();
            var button = $(button);
            var route = button.attr('data-route');
            var mes = button.attr('data-mes-success');
            var error = button.attr('data-mes-error');


            $.ajax({
                url: route,
                type: 'GET',
                success: function(result) {
                    // Show an alert with the result
                    // console.log(result, route);
                    new Noty({
                        text: 'تمت عملية' + mes,
                        type: "success"
                    }).show();

                    // Hide the modal, if any
                    // $('.modal').modal('hide');

                    crud.table.ajax.reload();
                },
                error: function(result) {
                    // Show an alert with the result
                    new Noty({
                        text: error,
                        type: "warning"
                    }).show();
                }
            });
        }
    }
</script>

{{-- ///////////////////////////////////////////////////////// --}}
