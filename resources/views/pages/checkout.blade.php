@extends('layouts.checkout')
@section('title', 'Checkout')

@section('content')
<main>
    <section class="section-details-header"></section>
    <section class="section-details-content">
      <div class="container">
        <div class="row">
          <div class="col p-0">
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  Paket Travel
                </li>
                <li class="breadcrumb-item">
                  Details
                </li>
                <li class="breadcrumb-item active">
                  Checkout
                </li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 pl-lg-0">
            <div class="card card-details">
              @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{$error}} </li>
                      @endforeach
                    </ul>
                  </div>
              @endif
              <h1>Who is Going?</h1>
              <p>Trip to {{$item->travel_package->title}}, {{$item->travel_package->location}}</p>
              <div class="attendee">
                <table class="table table-responsive-sm text-center">
                  <thead>
                    <tr>
                      <td>Picture</td>
                      <td>Name</td>
                      <td>Nationality</td>
                      <td>Visa</td>
                      <td>Passport</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($item->details as $detail)
                      <tr>
                        <td>
                          <img src="https://ui-avatars.com/api/?name={{$detail->username}}" height="60" class="rounded-circle">
                        </td>
                        <td class="align-middle">
                          {{$detail->username}}
                        </td>
                        <td class="align-middle">
                          {{$detail->nationality}}
                        </td>
                        <td class="align-middle">
                          {{$detail->is_visa ? '30 Days' : 'N/A'}}
                        </td>
                        <td class="align-middle">
                          {{ \Carbon\Carbon::createFromDate($detail->doe_passport) > \Carbon\Carbon::now() ? 'Active' : 'Inactive'}}
                        </td>
                        <td class="align-middle">
                          <a href="{{ Route('checkout-remove', $detail->id)}} ">
                            <i class="fa fa-window-close text-danger" aria-hidden="true"></i>
                          </a>
                        </td>
                      </tr>
                    @empty
                        <tr>
                          <td class="text-center" colspan="6">
                            No Visitor
                          </td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <div class="member mt-3">
                <h2>Add Member</h2>
                <form class="form-inline" method="POST" action="{{ Route('checkout-create', $item->id)}} ">
                  @csrf
                  <label for="username" class="sr-only">Name</label>
                  <input
                  type="text"
                  name="username"
                  class="form-control mb-2 mr-sm-2"
                  id="inputUsername"
                  placeholder="Username">
                  
                  <label for="nationality" class="sr-only">Nationality</label>
                  <input
                  type="text"
                  name="nationality"
                  class="form-control mb-2 mr-sm-2"
                  style="width: 50px"
                  id="nationality"
                  placeholder="Nationality" required>

                  <label for="is_visa" class="sr-only">Visa</label>
                  <select class="form-control mb-2 mr-sm-2" name="is_visa" id="is_visa" required>
                    <option disabled selected value="">VISA</option>
                    <option value="1">30 Days</option>
                    <option value="0">N/A</option>
                  </select>

                  <label for="doe_passport" class="sr-only">DOE Passport</label>
                  <div class="input-group mb-2 mr-sm-2">
                    <input
                    type="text"
                    class="form-control datepicker"
                    id="doePassport"
                    name="doe_passport"
                    placeholder="DOE Passport"/>
                  </div>

                  <button type="submit" class="btn btn-add-now mb-2 px-3" name="button">Add Now</button>
                </form>
                <h3 class="mt-2 mb-0">Note</h3>
                <p class="disclaimer mb-0">
                  You are only able to invite member that has registered in Nuew Travel.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-details card-right">
              <h2>Checkout Informations</h2>
              <table class="trip-informations">
                <tr>
                  <th width="50%">Members</th>
                  <td width="50%" class="text-right">
                    {{$item->details->count()}} People
                  </td>
                </tr>
                <tr>
                  <th width="50%">Additional VISA</th>
                  <td width="50%" class="text-right">
                    ${{$item->additional_visa}}
                  </td>
                </tr>
                <tr>
                  <th width="50%">Trip Price</th>
                  <td width="50%" class="text-right">
                    ${{$item->travel_package->price}}/ Person
                  </td>
                </tr>
                <tr>
                  <th width="50%">Sub Total</th>
                  <td width="50%" class="text-right">
                    ${{$item->transaction_total}}
                  </td>
                </tr>
                <tr>
                  <th width="50%">Total (+Unique)</th>
                  <td width="50%" class="text-right">
                    <span class="text-blue">$ {{$item->transaction_total}},</span>
                    <span class="text-orange">{{mt_rand(0,99)}}</span>
                  </td>
                </tr>
              </table>
              <hr>
              <h2>Payment Instructions</h2>
              <p class="payment-instruction" >Please complete your payment before continue the wonderful trip</p>
              <div class="bank">
                <div class="bank-item pb-3">
                  <img src="{{url('frontend/images/credit-card.png')}}" alt="" class="bank-image">
                  <div class="description">
                    <h3>PT Nuew Travel</h3>
                    <p>
                      081234567
                      <br>
                      Bank National Indonesia
                    </p>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="bank-item pb-3">
                  <img src="{{url('frontend/images/credit-card.png')}}" alt="" class="bank-image">
                  <div class="description">
                    <h3>PT Nuew Travel</h3>
                    <p>
                      081234567
                      <br>
                      Bank Central Asia
                    </p>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            <div class="join-container">
              <a href=" {{Route('checkout-success', $item->id)}} " class="btn btn-block btn-join-now mt-3 py-2">
                I Have Made Payment
              </a>
            </div>
            <div class="text-center mt-3">
              <a href="{{Route('detail', $item->travel_package->slug)}}" class="text-muted">
                Cancel Payment
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection

@push('prepend-style')
<link rel="stylesheet" href="{{url('frontend/libraries/gijgo/css/gijgo.min.css')}}">
@endpush

@push('addon-script')
<script src="{{url('frontend/libraries/gijgo/js/gijgo.min.js')}}"></script>
<script>
    $(document).ready(function(){

      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        icons: {
          rightIcon:'<i class="fa fa-calendar text-primary" aria-hidden="true"></i>'
        }
      });
    });
  </script>
@endpush