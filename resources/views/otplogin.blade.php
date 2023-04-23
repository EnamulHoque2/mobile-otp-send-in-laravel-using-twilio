<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(session('error'))
        <div style="color:red">
            {{session('error')}}
        </div>
    @endif
    <form action="{{ route('otp.generate')}}" method="POST">
        @csrf
        <label for="">Enter Name</label>
        <br>
        <input type="text" name="mobile_no" id="mobile_no" value="{{ old('mobile_no')}}">
        @error('mobile_no')
            <span style="color:red">{{$message}}</span>
        @enderror
        <br>
        <button type="submit">Generate OTP</button>
    </form>
</body>
</html>