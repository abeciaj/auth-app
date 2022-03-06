<h1>Home page</h1>

<h3>Welcome, {{ $name }}</h3>


<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf  
    <button type="submit" class="btn btn-dark btn-block">Logout</button>
</form>