@extends('layout')

@push('styles')

<style>

.carousel-item {
  height: 75vh;
  min-height: 15rem;
  background: no-repeat center center scroll;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
@endpush

@section('contenido')
<!-- Navegación -->

<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #3864AD;">
  <a class="navbar-brand" href="#">
    @if($negocio[0]->logotipo)
    <img src="{{$negocio[0]->logotipo}}" height="50rem" style="fill:blue">
    @endif
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent" color="white">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link"  href="#"><h4>Sistema Integral de Gestión del Colegio de Ingenieros de Guatemala -<strong> SIGECIG</strong></h4> <span class="sr-only">(current)</span></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{url('/admin')}}">Home</a>
      </li>
      <!-- Authentication Links -->
      @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
      @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    {{ __('Salir') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
          </li>
      @endguest
    </ul>
  </div>
</nav>
    <!-- carrousel -->

<div class="row text-center">
  <div class="col-md-3 col-sm-12 col-xs-12 pl-5 pr-5 mt-5 pt-5 text-center centra_vertical">
    <img class="img-fluid" src="/images/logocig.png" width="400px">
  </div>
  <div class="col-md-9 col-sm-12 col-xs-12 mt-5 pt-5 text-right centra_vertical">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block img-fluid" width="900px" src="{{url('images/imagen1.jpg')}}" alt="First slide" >
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" width="900px" src="{{url('images/imagen2.jpg')}}" alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" width="900px" src="{{url('images/imagen3.jpg')}}" alt="Third slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
  </div>
</div>



 <!-- Pié de página -->
    <footer>
        <div class="container">
          <div class="row">
            <div class="col-lg-10 col-md-10 mx-auto">
              <u{l class="list-inline text-center">
            {{--<li class="list-inline-item">
                  <a href="#">
                    <span class="fa-stack fa-lg">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                    </span>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <span class="fa-stack fa-lg">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                    </span>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <span class="fa-stack fa-lg">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fab fa-youtube fa-stack-1x fa-inverse"></i>
                    </span>
                  </a>
                </li> --}}
              </ul>
              <center><p class="copyright text-muted"><strong>Copyright &copy; 2020 · Colegio de Ingenieros de Guatemala -CIG. All rights reserved</strong> </p></center>
            </div>
          </div>
        </div>
      </footer>
@endsection

@push('scripts')
@endpush
