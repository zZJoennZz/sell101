<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
        }
        .login-container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                @if(session('error'))
                    <div class="card-panel red lighten-2 white-text center-align">
                        {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="card-panel red lighten-2 white-text">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="card-panel green lighten-2 white-text center-align">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title center-align">Login</span>
                        <form method="POST" action="{{ route('admin.postlogin') }}">
                            @csrf
                            <div class="input-field">
                                <i class="material-icons prefix">email</i>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                                <label for="email">Email</label>
                                @error('email')
                                    <span class="helper-text red-text">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">lock</i>
                                <input id="password" type="password" name="password" required>
                                <label for="password">Password</label>
                                @error('password')
                                    <span class="helper-text red-text">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="center-align">
                                <button class="btn waves-effect waves-light" type="submit">Login
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        M.AutoInit();
    </script>
</body>
</html>