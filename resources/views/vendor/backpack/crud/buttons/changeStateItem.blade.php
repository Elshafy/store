<a href="javascript:void(0)" onclick="change(this)"
    data-route="{{ url($crud->route . '/' . $entry->getKey() . '/changeState') }}"
    class="btn btn-sm btn-link text-capitalize" data-button-type="change">
    <i class="la la-question"></i>
    {{ trans('item.changeStateItem') }}
</a>



<script>
    if (typeof change != 'function') {
        $("[data-button-type=change]").unbind('click');

        function change(button) {
            // ask for confirmation before deleting an item
            // e.preventDefault();
            var button = $(button);
            var route = button.attr('data-route');

            $.ajax({
                url: route,
                type: 'GET',
                success: function(result) {
                    // Show an alert with the result
                    // console.log(result, route);
                    new Noty({
                        text: "Some Tx had been imported",
                        type: "success"
                    }).show();

                    // Hide the modal, if any
                    // $('.modal').modal('hide');

                    crud.table.ajax.reload();
                },
                error: function(result) {
                    // Show an alert with the result
                    new Noty({
                        text: "The new entry could not be created. Please try again.",
                        type: "warning"
                    }).show();
                }
            });
        }
    }
</script>

{{-- ///////////////////////////////////////////////////////// --}}
