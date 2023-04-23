<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(session('success'))
        <div style="color:rgb(0, 255, 166)">
            {{session('success')}}
        </div>
    @endif

    @if(session('error'))
        <div style="color:red">
            {{session('error')}}
        </div>
    @endif
    
    <form action="{{ route('otp.loginwithotp')}}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{$user_id}}">
        <label for="">OTP</label>
        <input type="text" name="otp" id="" value="{{old('otp')}}">
        @error('otp')
        <div style="color:red">
            {{$message}}
        </div>
        @enderror
        <br>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>