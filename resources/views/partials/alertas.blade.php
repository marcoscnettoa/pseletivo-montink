@if(session('success') || $errors->all())
    <div class="mt-1">
        <div class="row">
            @foreach($errors->all() as $erro)
                <div class="col-md-12">
                    <div class="alert alert-danger mb-25 d-inline-block" role="alert">
                        <i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;{!! $erro !!}
                    </div>
                </div>
            @endforeach
            @if(session('success'))
                <div class="col-md-12">
                    <div class="alert alert-success mb-25 d-inline-block" role="alert">
                        <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;{!! session('success') !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
