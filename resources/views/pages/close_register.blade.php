@extends('layouts.app')
@section('title', '已关闭注册')

@section('content')
  <div class="col-md-8 offset-md-2">
    <div class="card ">
      <div class="card-body">
        @if (Auth::check())
          <div class="alert alert-danger text-center mb-0">
            已关闭注册。
          </div>
        @else
          <div class="alert alert-danger text-center">
            已关闭注册。 联系QQ {{ env('QQ',123456) }} 获得邀请
            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2::53" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>
          </div>

        @endif
      </div>
    </div>
  </div>
@stop
