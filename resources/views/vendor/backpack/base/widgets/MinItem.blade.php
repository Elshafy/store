@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_start')
<div class="{{ $widget['class'] ?? 'well mb-2' }}">
    {{-- {!! $widget['content'] !!} --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-align-justify"></i> min Item</div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>category</th>
                                <th>name</th>
                                <th>amount</th>
                                <th>min</th>
                                <th>price</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($widget['content']['items'] as $item)
                                <tr>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->min }}</td>
                                    <td>{{ $item->price }}</td>


                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <nav>
                    </nav>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
</div>
@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_end')
