@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="text-center my-3">Contact Us</h1>
    <div class="contact__wrapper shadow-lg mt-n9">
        <div class="row no-gutters">
            <div class="col-lg-5 contact-info__wrapper gradient-brand-color p-5 order-lg-2">
                <h3 class="color--white mb-5">Contact</h3>
    
                <ul class="contact-info__list list-style--none position-relative z-index-101">
                    <li class="mb-4 pl-4">
                        <span class="position-absolute"><i class="fas fa-envelope"></i></span> {{config('mail.from.address')}}
                    </li>
                    <li class="mb-4 pl-4">
                        <span class="position-absolute"><i class="fas fa-phone"></i></span> +32 71 123 456
                    </li>
                    <li class="mb-4 pl-4">
                        <span class="position-absolute"><i class="fas fa-map-marker-alt"></i></span> E6K
                        <br> Quai de la gare
                        <br> 6000 Charleroi
    
                        <div class="mt-3">
                            <a href="https://www.google.com/maps" target="_blank" class="text-link link--right-icon text-white">Itinéraire <i class="link__icon fa fa-directions"></i></a>
                        </div>
                    </li>
                </ul>
    
                <figure class="figure position-absolute m-0 opacity-06 z-index-100" style="bottom:0; right: 10px">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="444px" height="626px">
                        <defs>
                            <linearGradient id="PSgrad_1" x1="0%" x2="81.915%" y1="57.358%" y2="0%">
                                <stop offset="0%" stop-color="rgb(255,255,255)" stop-opacity="1"></stop>
                                <stop offset="100%" stop-color="rgb(0,54,207)" stop-opacity="0"></stop>
                            </linearGradient>
    
                        </defs>
                        <path fill-rule="evenodd" opacity="0.302" fill="rgb(72, 155, 248)" d="M816.210,-41.714 L968.999,111.158 L-197.210,1277.998 L-349.998,1125.127 L816.210,-41.714 Z"></path>
                        <path fill="url(#PSgrad_1)" d="M816.210,-41.714 L968.999,111.158 L-197.210,1277.998 L-349.998,1125.127 L816.210,-41.714 Z"></path>
                    </svg>
                </figure>
            </div>
    
            <div class="col-lg-7 contact-form__wrapper p-5 order-lg-1">
                <form action="{{route('email.contact.us')}}" method="POST" class="contact-form form-validate" novalidate="novalidate">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="required-field" for="firstName">Prénom*</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Jean">
                            </div>
                        </div>
    
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="lastName">Nom*</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Dupont">
                            </div>
                        </div>
    
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="required-field" for="email">Email*</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="jean@dupont.com" value="@auth {{Auth::user()->email}} @endauth">
                            </div>
                        </div>
    
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Téléphone*</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="+32 71 123 456">
                            </div>
                        </div>
    
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="required-field" for="message">Comment pouvons-nous vous aider ?*</label>
                                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Bonjour, j'aimerais…"></textarea>
                            </div>
                        </div>
    
                        <div class="col-sm-12 mb-3">
                            <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
                        </div>
    
                    </div>
                </form>
            </div>
            <!-- End Contact Form Wrapper -->
    
        </div>
    </div>
</div>
@endsection