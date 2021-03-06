@extends('layouts.app')

@section('title', $topic->title)
@section('description', $topic->excerpt)

@section('content')

  <div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
      <div class="card ">
        <div class="card-body">
          <div class="text-center">
            作者：{{ $topic->user->name }}
          </div>
          <hr>
          <div class="media">
            <div align="center">
              <a href="{{ route('users.show', $topic->user->id) }}">
                <img class="thumbnail img-fluid" src="{{ $topic->user->avatar }}" width="300px" height="300px">
              </a>
            </div>
          </div>

          <div class="card-body">
            <div align="text-center alert-primary">
              余额：{{ $topic->user->money }}
              <br>
              发贴：
              <a href="{{ route('users.show',$topic->user->id) }}">
                {{ $topic->user->topics->count() }}
              </a>

            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">

      <div class="card ">
        <div class="card-body">
          <h1 class="text-center mt-3 mb-3">
            {{ $topic->title }}
          </h1>

          <div class="article-meta text-center text-secondary">
            {{ $topic->created_at->diffForHumans() }}
            ⋅
            <i class="far fa-comment"></i>
            {{ $topic->reply_count }}
            ⋅
            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
            {{ $topic->buyer_count }}
            ⋅
            <i class="fa fa-money" aria-hidden="true"></i>
            {{ $topic->amount }}
          </div>

          <div class="topic-body mt-4 mb-4">
            {!! $topic->body !!}
            <hr>
            <div>
              @guest
                <a href="{{ route('login') }}" class="btn btn-outline-info btn-block" disabled>登陆后可观看剩余内容</a>
              @else
                @if($showPremium)
                  {!! $topic->premium !!}
                @elseif(\Auth::user()->money >= $topic->price)
                  <form action="{{ route('topics.premium',$topic->id) }}" method="post">
                    {{ csrf_field() }}
                    <button type="submit"
                            class="btn btn-outline-danger btn-block" >购买付费内容 ￥{{ $topic->price }}</button>
                  </form>
                @else
                  <button type="button"  class="btn btn-outline-dark btn-block" disabled>购买付费内容 ￥{{ $topic->price }} 您的金币不足</button>
                @endif
              @endguest
            </div>
          </div>

          @can('update',$topic)
            <div class="operate">
              <hr>
              <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                <i class="far fa-edit"></i> 编辑
              </a>
              <form action="{{ route('topics.destroy',$topic->id) }}" method="post"
                    style="display: inline-block;"
                    onsubmit="return confirm('确定删除吗?')">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-outline-secondary btn-sm" type="submit">
                  <i class="far fa-trash-alt"></i> 删除
                </button>
              </form>
            </div>
          @endcan
        </div>
      </div>

      {{--  用户回复列表  --}}
      <div class="card topic-reply mt-4">
        <div class="card-body">
          @includeWhen(Auth::check(),'topics._reply_box',['topic'=>$topic])
          @include('topics._reply_list',['replies'=>$topic->replies()->with('user','topic')->get()])
        </div>
      </div>

    </div>

  </div>
@stop
