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
            已关闭注册。 联系QQ 1276760312 获得邀请
          </div>

        @endif
      </div>
    </div>
  </div>
@stop
