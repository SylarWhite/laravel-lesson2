@extends('layouts.app')

@section('title',$user->name . ' 的个人中心')

@section('content')

  <div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
      <div class="card">
        <img alt="{{ $user->name }}" src="{{ $user->avatar }}" class="card-img-top">
        <div class="card-body">
          <h5><strong>个人简介</strong></h5>
          <p>{{ $user->introduction }}</p>
          <hr>
          <h5><strong>注册于</strong></h5>
          <p>{{ $user->created_at->diffForHumans() }}</p>
          <hr>
          <h5><strong>最后活跃</strong></h5>
          <p title="{{  $user->last_actived_at }}">{{ $user->last_actived_at->diffForHumans() }}</p>
          <hr>
          <h5><strong>金币余额</strong></h5>
          <p title="{{  $user->money }}">{{ $user->money }}金币 ( {{ $user->money / 10 }} 元 )</p>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
      <div class="card ">
        <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
        </div>
      </div>
      <hr>

      {{-- 用户发布的内容 --}}
      <div class="card ">
        <div class="card-body">

          <table class="table-striped table">
            <tr>
              <th>id</th><th>金额</th><th>类型</th><th>消费对象</th><th>时间</th>
            </tr>
            @foreach($records as $record)
              <tr>
                <td>{{ $record->id }}</td>
                <td>{{ $record->money }}</td>
                <td>{{ $record->type == 3 ? '消费' :  $record->type == 2 ? '提款' : $record->type == 1 ? '消费' : '其他' }}</td>
                <td>{{ !empty($record->topic_id) ? $record->topic->title : '' }}</td>
                <td>{{ $record->created_at->diffForHumans() }}</td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>

    </div>

  </div>

@endsection
