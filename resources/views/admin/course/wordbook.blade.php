@extends('layouts.admin')
@section('title', '単語帳')
@section('content')
　　　　　　　{{$user->name}}さんの単語帳 "{{$unique_category}}"
<div class="container">
    @if($message != "")
        <p>{{$message}}</p>
        {{--この行に、ここ以下のコードを実行しない命令を記述するべきと考えられるものの、思いつかないため保留2021.8.13--}}
    @endif
    <p class="col">
    <a  class="btn btn-warning" href="{{action('Admin\CourseController@write',['category'=>$unique_category,'tango_id'=>$post[$tango_id]->id,'page'=>$tango_id])}}">編集</a> {{--  URL：?tango_id=1が生成される（URLにおいて?で送られる数値をgetパラメータという--}} 
    <a  class="btn btn-warning" href="{{action('Admin\CourseController@quiz',['category'=>$unique_category])}}">この科目のクイズへ</a>
    </p>
    {{--<div>*ここからデバッグ用の記述です</div>
    <h6>(今のページの)<br>user_idは {{$user->id}}<br>course_idは {{$post[$tango_id]->id}}<br>
    関連する<br>histories_tableのidは 
    @if($value != NULL)
        {{$value->id}}<br>learning_levelは {{$value->learning_level}}
    @else
        ありません（まだレコードなし）
    @endif
    </h6>
    ここまでデバッグ用の記述です*<br>--}}
    <div class="col">
        @if($value == NULL or $value->learning_level == 0 or $value->learning_level == 1 ) {{-- もしhistoriesテーブルのtango_id番めのレコードの learning_level が0かNULLなら --}}
            <form action="{{ action('Admin\StatusController@store') }}" method="post" enctype="multipart/form-data">  {{--  ActionタグにURLを書く--}} 
            @csrf
                <p>
                    <input type="hidden" name="course_id" value={{$post[$tango_id]->id}}> {{--1ページごとなので、foreachではなく具体的な数値を$tango_idで渡している--}} 
                    <input type="hidden" name="learning_level" value="2"> {{--すでに知っている」をsubmitしたとき、0→1へ切り替える--}}
                    <input type="hidden" name="tango_id" value= {{$tango_id}}>{{--再度同じページにredirectするために、$tango_idを渡す--}}
                    <input type="hidden" name="category" value= {{urlencode($unique_category)}}>
                    <input type="submit" class="btn btn-primary" value="最初から知ってる">
                </p>
            </form>
        @else
            <form action="{{ action('Admin\StatusController@store') }}" method="post" enctype="multipart/form-data">  {{--  ActionタグにURLを書く--}}
            @csrf
                <p>
                    <input type="hidden" name="course_id" value={{$post[$tango_id]->id}}>
                    <input type="hidden" name="learning_level" value="1"> {{--最初から知っている を解除」をsubmitしたとき、0へ切り替える--}}
                    <input type="hidden" name="tango_id" value= {{$tango_id}}>
                    <input type="hidden" name="category" value= {{urlencode($unique_category)}}>
                    <input type="submit" class="btn btn-secondary" value="最初から知ってる を解除">
                </p>
            </form>
        @endif
    </div>
    <div class="col">
        @if($value == NULL or $value->learning_level == 0 ) {{-- もしhistoriesテーブルのtango_id番めのレコードの learning_level が1,0かNULLなら --}}
            <form action="{{ action('Admin\StatusController@store') }}" method="post" enctype="multipart/form-data">  {{--  ActionタグにURLを書く--}} 
            @csrf
                <p>
                    <input type="hidden" name="course_id" value={{$post[$tango_id]->id}}> {{--1ページごとなので、foreachではなく具体的な数値を$tango_idで渡している--}} 
                    <input type="hidden" name="learning_level" value="1"> {{--覚えたをsubmitしたとき、0→2へ切り替える--}}
                    <input type="hidden" name="tango_id" value= {{$tango_id}}>{{--再度同じページにredirectするために、$tango_idを渡す--}}
                    <input type="hidden" name="category" value= {{urlencode($unique_category)}}>
                    <input type="submit" class="btn btn-primary" value="覚えた">
                </p>
            </form>
        @else
            <form action="{{ action('Admin\StatusController@store') }}" method="post" enctype="multipart/form-data">  {{--  ActionタグにURLを書く--}}
            @csrf
                <p>
                    <input type="hidden" name="course_id" value={{$post[$tango_id]->id}}>
                    <input type="hidden" name="learning_level" value="0"> {{--最初から知っている を解除」をsubmitしたとき、0へ切り替える--}}
                    <input type="hidden" name="tango_id" value= {{$tango_id}}>
                    <input type="hidden" name="category" value= {{urlencode($unique_category)}}>
                    <input type="submit" class="btn btn-secondary" value="覚えた を解除">
                </p>
            </form>
        @endif
    </div>
    <div class="row col">
        <div class="text-center">
            <button type="button" class="btn btn-warning"><font size="6">{{ $post[$tango_id]->front }}</font></button> {{--...course_id:{{$post[$tango_id]->id}}--}}
        </div>
    </div>
    <div>
        {{-- JavaScript --}} 
        <p id="p1">{{ $post[$tango_id]->back }}</p>
        <input type="button" value="裏面on/off" onclick="clickBtn1()" />
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
    </div>
        <input type="button" value="ヒント画像on/off" onclick="clickBtn2()" /> {{--onclick 動かす関数を指定している  --}} 
    <div class="card" style="width: 18rem;">
        <img src="{{ asset('storage/tango/' . $post[$tango_id]->id . "." . 'jpg') }}" id="piyo" class="bd-placeholder-img card-img-top" width="100%" height="180"> 
    </div>     {{-- asset()でディレクトリを指定、受け取っている値で詳しいファイル名を指定 --}}
    <div>
        <script>
            //初期表示は非表示
            document.getElementById("piyo").style.display ="none";
            
            function clickBtn2(){
              const p2 = document.getElementById("piyo"); 
            
              if(p2.style.display=="block"){ {{--もしp2が表示されていれば  --}} 
              	// noneで非表示
              	p2.style.display ="none"; {{--  p2のスタイル（CSS）display属性を非表示にする（見えなくなる） --}} 
              }else{
              	// blockで表示
              	p2.style.display ="block";{{--  p2のスタイル（CSS）display属性を表示にする（見えるようにする） --}} 
              }
            }
        </script>
    </div>
    <div class="row justify-content-center">
        <div>
        @if($tango_id == 0)
        @else
            <a href="{{ action('Admin\CourseController@wordbook', ['tango_id' =>$tango_id -1, 'category' => $unique_category]) }}">
            <button type="button" class="btn btn-warning"><font size="1">◀</font></button><br>前へ</a>
        @endif
        </div>
        <div class="col-auto">
            {{--＠今何ページ目か表示--}}{{$tango_id +1}} / {{--＠全何ページか表示--}}{{$post->count()}}
        </div>
        <div class="col col-lg-2">
        @if($tango_id +1 == $post->count())
            <a href="{{action('Admin\CourseController@quiz',['category'=>$unique_category])}}">
            <button type="button" class="btn btn-warning"><font size="1">Q</font></button><br>最後の単語です</a><br>
        @else
            <a href="{{ action('Admin\CourseController@wordbook', ['tango_id' =>$tango_id + 1, 'category' => $unique_category]) }}">
            <button type="button" class="btn btn-warning"><font size="1">▶</font></button><br>次へ</a><br>
            <a href="{{ action('Admin\CourseController@wordbook', ['tango_id' =>$tango_id + 5, 'category' => $unique_category]) }}">5個次へ</a>
        @endif
        </div>
    </div>
</div>
<label class="col-md-12">　　カードはどのレベルまで表示しますか？</label>
<div>
   　　　<input type="radio" name="looking_level" value="0" <?php if($user->looking_level == 0){ echo "checked";} ?>>全部表示
</div>
<div>
   　　　 <input type="radio" name="looking_level" value="1" <?php if($user->looking_level == 1){ echo "checked";} ?>>[最初から知ってる] のカードを隠す
</div>
<div>
   　　　 <input type="radio" name="looking_level" value="1" <?php if($user->looking_level == 2){ echo "checked";} ?>>[最初から知ってる]と [覚えた]のカードを隠す
</div>
    <form action="{{ action('Admin\StatusController@levelChange') }}" method="post" enctype="multipart/form-data">  {{--  ActionタグにURLを書く--}} 
    @csrf
            <button type="submit" class="btn btn-primary" name="looking_level" value= 0> looking_level = 0</button> /全部表示
            <input type="hidden" name="tango_id" value= {{$tango_id}}>
            <input type="hidden" name="category" value= {{mb_convert_encoding($unique_category, 'UTF-8')}}>
    </form>
    <form action="{{ action('Admin\StatusController@levelChange') }}" method="post" enctype="multipart/form-data">  {{--  ActionタグにURLを書く--}} 
    @csrf
            <button type="submit" class="btn btn-primary" name="looking_level" value= 1> looking_level = 1</button> /[最初から知ってる] のカードを隠す
            <input type="hidden" name="tango_id" value= {{$tango_id}}>
            <input type="hidden" name="category" value= {{mb_convert_encoding($unique_category, 'UTF-8')}}>
    </form>
    <form action="{{ action('Admin\StatusController@levelChange') }}" method="post" enctype="multipart/form-data">  {{--  ActionタグにURLを書く--}} 
    @csrf
            <button type="submit" class="btn btn-primary" name="looking_level" value= 2> looking_level = 2</button> /[最初から知ってる]と [覚えた]のカードを隠す
            <input type="hidden" name="tango_id" value= {{$tango_id}}>
            <input type="hidden" name="category" value= {{mb_convert_encoding($unique_category, 'UTF-8')}}>
    </form>
<div class="text-center">
</div>
@endsection