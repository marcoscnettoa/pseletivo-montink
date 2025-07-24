@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-box color-st1"></i>&nbsp;&nbsp;Estoques</h3>
                </div>
            </div>
            @include('partials.alertas')
        </div>
        <div class="content-body mt-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-content mt-1">
                                <div class="table-responsive">
                                    <table class="table table-st1 table-striped table-bordered datatable-st1">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="80" data-orderable="false">#</th>
                                                <th class="text-center" width="60"># ID</th>
                                                <th class="text-left">Produto</th>
                                                <th class="text-left">Nome / Variação</th>
                                                <th class="text-left" width="50">Quantidade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($estoques->count())
                                            @foreach($estoques as $estoque)
                                                <tr>
                                                    <td class="text-center" nowrap>
                                                        <a href="{{route('estoques.edit',['id'=>$estoque->id])}}" class="btn btn-sm btn-primary-st2"><i class="fa fa-edit fa-ico-fix-top1px"></i></a>
                                                        <button type="button" href="javascript:void(0);" data-href="{{route('estoques.destroy',['id'=>$estoque->id])}}" data-hash="{{$estoque->id}}" data-method="DELETE" data-type="warning" data-title="Excluir" data-msg="Deseja realmente excluir este estoque?" class="btn btn-sm btn-danger app-confirm"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                    <td class="text-center" nowrap>{{$estoque->id}}</td>
                                                    <td class="text-left" nowrap>
                                                        @php
                                                            $imagem             = (($estoque->getProduto && !empty($estoque->getProduto->imagem))?URL('/storage').'/'.$estoque->getProduto->imagem:URL('/').'/assets/images/default.jpg');
                                                            $imagem             = (!\App\Helpers\Helper::http_url_head_ok($imagem)?URL('/').'/assets/images/default.jpg':$imagem);
                                                        @endphp
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-2">
                                                                <img src="{{$imagem}}" width="50" alt="Imagem" />
                                                            </div>
                                                            <div class="">
                                                                {{ (($estoque->getProduto && $estoque->getProduto->nome) ? $estoque->getProduto->nome : '---' ) }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-left" nowrap>{{ (($estoque->getVariacao && $estoque->getVariacao->nome) ? $estoque->getVariacao->nome : '---' ) }}</td>
                                                    <td class="text-left" nowrap>{{( $estoque->quantidade ? $estoque->quantidade : '---' )}}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{route('estoques.create')}}" class="btn btn-sm btn-primary-st2"><i class="fa fa-plus"></i>&nbsp;&nbsp;Cadastrar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        /* ... */
    </script>
@endsection
