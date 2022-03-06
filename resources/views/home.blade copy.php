<h1>Home page</h1>

<h3>Welcome, {{ $name }}</h3>



<form action="{{ route('logout') }}" method="post">
    
    <div class="d-grid mx-auto">
        <button type="submit" class="btn btn-dark btn-block">Logout</button>
    </div>
</form>