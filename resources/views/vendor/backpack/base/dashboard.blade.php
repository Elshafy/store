@extends(backpack_view('blank'))

@php
if (config('backpack.base.show_getting_started')) {
    $widgets['before_content'][] = [
        'type' => 'view',
        'view' => 'backpack::inc.getting_started',
    ];
} else {
    $widgets['before_content'][] = [
        'type' => 'jumbotron',
        'heading' => trans('backpack::base.welcome'),
        'content' => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];
}
Widget::add([
    'type' => 'disableditems',
    'wrapper' => ['class' => 'col-sm-12'],
    'content' => [
        'items' => (new \App\Http\Controllers\WidgetController())->disableditems(),
    ],
]);

Widget::add([
    'type' => 'itemWithExportMport',
    'wrapper' => ['class' => 'col-sm-12'],
    'content' => [
        'items' => (new \App\Http\Controllers\WidgetController())->itemWithExportMport(),
    ],
]);
@endphp

@section('content')
@endsection
