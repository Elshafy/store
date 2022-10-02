@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_start')
<div class="{{ $widget['class'] ?? 'well mb-2' }}">
    {{-- {!! $widget['content'] !!} --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-align-justify"></i> disabled Items</div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>name </th>
                                <th>amount export</th>
                                <th>amount import</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($widget['content']['items'] as $item)
                                {{-- @dd($item) --}}
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->exports->sum('amount') }}</td>
                                    <td>{{ $item->imports->sum('amount') }}</td>
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
