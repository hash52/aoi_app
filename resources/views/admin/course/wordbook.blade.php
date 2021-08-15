{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'最初の画面'を埋め込む --}}
@section('title', '単語帳')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
  <div class="container">
    <br>
    @if($message != "")
       <p>{{$message}}</p>
        {{--この行に、ここ以下のコードを実行しない命令を記述するべきと考えられるものの、思いつかないため保留2021.8.13--}}
    @endif
    <br>
    <div class="row justify-content-around">
      <div class="col-4">
        <a href=""></a>
      </div>
      <div class="col-4">
        <form action="{{-- action('Admin\StatusController@store') --}}" method="post" enctype="multipart/form-data"> {{-- multipart/form-data は複数データ送信用 --}} 
         @csrf  {{--  セキュリティに関係するもので、必要--}} 
            <input type="submit" class="btn btn-primary" value="覚えた">{{-- bool値 trueを送りたい--}}
           {{-- hiddenタグをinputタグより前に置く --}} 
        </form>
        <form action="{{ action('Admin\StatusController@store') }}" method="post" enctype="multipart/form-data">  {{--  ActionタグにURLを書く--}} 
          @csrf
          <p>
            <input type="hidden" name="course_id" value={{$post[$tango_id]->id}}> {{--1ページごとなので、foreachではなく具体的な数値を$tango_idで渡している--}} 
            <input type="hidden" name="hide_learned" value="1">
            <input type="hidden" name="hide_known" value="1"> {{--すでに知っている」をsubmitしたとき、0→1へ切り替える--}}
            <input type="submit" value="すでに知っている">
          </p>
        </form> 
      </div>
      <div class="col-4">
        <a href="{{action('Admin\CourseController@write',['tango_id'=>$post[$tango_id]->id])}}">編集</a> {{--  URL：?tango_id=1が生成される（URLにおいて?で送られる数値をgetパラメータという--}} 
      </div>
    </div>
    <br>
    <br>
    <div class="row">
      <div class="col-6 offset-3">
        <button type="button" class="btn btn-warning"><font size="4">@front_text</font></button>
         <br><br>
          <h1>{{ $post[$tango_id]->front }}</h1>
          {{-- JavaScript --}} 
          <p id="p1">{{ $post[$tango_id]->back }}</p>
          <input type="button" value={{$post[$tango_id]->front}} onclick="clickBtn1()" />
          <script>
          //初期表示は非表示
          document.getElementById("p1").style.display ="none";
          
          function clickBtn1(){
          	const p1 = document.getElementById("p1");
          
          	if(p1.style.display=="block"){
          		// noneで非表示
          		p1.style.display ="none";
          	}else{
          		// blockで表示
          		p1.style.display ="block";
          	}
          }
          </script>
         <br><br>
        <button type="button" class="btn btn-warning"><font size="3">@image をヒントとして表示するボタン</font></button>
       <img src="{{ asset('storage/tango/' . $post[$tango_id]->id . "." . 'jpg') }}"> {{-- asse()でディレクトリを指定、受け取っている値で詳しいファイル名を指定 --}}
      </div>
    </div>
    <br>
    <br>
    {{ $post[0]->front }}{{ $post[1]->front }}{{ $post[2]}}
    <div class="row justify-content-center">
        <div class="col col-lg-2">
          <button type="button" class="btn btn-warning"><font size="1">◀</font></button><br>
          <a href="{{ action('Admin\CourseController@wordbook', ['tango_id' =>$tango_id -1]) }}">前へ</a>
        </div>
        <div class="col-auto">
          {{-- {{--＠今何ページ目か表示--}}{{$tango_id +1}} / {{--＠全何ページか表示--}}{{$post->count()}}
        </div>
        <div class="col col-lg-2">
          <button type="button" class="btn btn-warning"><font size="1">▶</font></button><br>
          <a href="{{ action('Admin\CourseController@wordbook', ['tango_id' =>$tango_id + 1]) }}">次へ</a><br>
          <a href="{{ action('Admin\CourseController@wordbook', ['tango_id' =>$tango_id + 2]) }}">２個次へ</a>
        </div>
    </div>
  </div>
<br> {{$user->name}}
<br> {{$user->email}}
<br> {{$users[0]->email}}
@endsection