@extends('layouts.app')

@section('content')

<div class="page-header mx-2">
    <div>
        <h1 class="page-title">{{ @trans('messages.dashboard') }}</h1>
    </div>
    <div class="ms-auto pageheader-btn d-none d-xl-flex d-lg-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ @trans('messages.dashboard') }}</li>
        </ol>
    </div>
</div>


<div class="row d-flex justify-content-center">

    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="row">
                    <div class="col d-flex flex-column justify-content-between">
                        <p class="text-muted fs-17 mb-0">{{ @trans('messages.total_content') }}</p>
                        <div class="d-flex justify-content-start">
                            <!-- <div class="d-flex flex-column align-items-end justify-content-end">
                                <span class="dashboard-currency me-2">Total:</span>
                            </div> -->
                            <div class="d-flex align-items-start">
                                <h4 class="fw-semibold spincrement m-0 text-danger" id="">{{ $total_contents ?? 0 }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col col-auto top-icn dash">
                        <div class="counter-icon bg-danger dash ms-auto box-shadow-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="row">
                    <div class="col d-flex flex-column justify-content-between">
                        <p class="text-muted fs-17 mb-0">{{ @trans('messages.total_customer') }}</p>

                        <div class="d-flex justify-content-start">
                            <!-- <div class="d-flex flex-column align-items-end justify-content-end">
                                <span class="dashboard-currency me-2">Total:</span>
                            </div> -->
                            <div class="d-flex align-items-start">
                                <h4 class="fw-semibold spincrement m-0 text-warning" id="">{{ $total_customer ?? 0 }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col col-auto top-icn dash">
                        <div class="counter-icon bg-warning dash ms-auto box-shadow-primary">
                            <svg class="fw-bold text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                <path d="M32.21484 25.75a5.25 5.25 0 1 1 5.25-5.25A5.25605 5.25605 0 0 1 32.21484 25.75zm0-9a3.75 3.75 0 1 0 3.75 3.75A3.75442 3.75442 0 0 0 32.21484 16.75zM38.78516 60.75h43.77539a.7502.7502 0 0 1-.75-.75V48A1.25279 1.25279 0 0 0 32 46.77 1.25279 1.25279 0 0 0 30.97461 48V60a.7502.7502 0 0 1-.75.75H25.21484a.7502.7502 0 0 1-.75-.75V36.23291l-1.876 1.6416a.73215.73215 0 0 1-.56348.18213l-11.87988-1.1001a.74982.74982 0 0 1-.4834-1.2539l2.03027-2.21a.74915.74915 0 0 1 .4209-.231l8.68164-1.55567 3.89942-4.21533a.75212.75212 0 0 1 .55078-.24072h4.22949a.7482.7482 0 0 1 .625.33594A3.71832 3.71832 0 0 0 32 29.24414a3.71832 3.71832 0 0 0 2.90039-1.6582.7482.7482 0 0 1 .625-.33594h4.22949a.75212.75212 0 0 1 .55078.24072l3.89942 4.21533 8.68164 1.55567a.74915.74915 0 0 1 .4209.231l2.03027 2.21a.74982.74982 0 0 1-.4834 1.2539l-11.87988 1.1001a.74549.74549 0 0 1-.56348-.18213l-1.876-1.6416V60A.7502.7502 0 0 1 38.78516 60.75zm-4.25977-1.5h4.50977V34.58008a.75017.75017 0 0 1 1.24414-.56445l2.87793 2.51806L52.209 35.60254l-.835-.90869-8.68066-1.55567a.753.753 0 0 1-.41895-.229L38.42676 28.75h45.90918a5.21084 5.21084 0 0 1-3.44043 1.95605.75365.75365 0 0 1-.25391.04395h-.42968a.75365.75365 0 0 1-.25391-.04395A5.21084 5.21084 0 0 1 28.09082 28.75H25.57324l-3.84765 4.15918a.753.753 0 0 1-.41895.229L12.626 34.69385l-.835.90869 10.05175.93115 2.87793-2.51806a.75017.75017 0 0 1 1.24414.56445V59.25h4.50977V48a2.75455 2.75455 0 0 1 1.84863-2.59814.74457.74457 0 0 1 .45215-.15186h.44922a.74457.74457 0 0 1 .45215.15186A2.75455 2.75455 0 0 1 34.52539 48zM12 29.75A8.75 8.75 0 1 1 20.75 21 8.75967 8.75967 0 0 1 12 29.75zm0-16A7.25 7.25 0 1 0 19.25 21 7.258 7.258 0 0 0 12 13.75z" fill="#fff"></path>
                                <path d="M12.5,24.75H10a.75.75,0,0,1,0-1.5h2.5a.75.75,0,0,0,0-1.5h-1a2.25,2.25,0,0,1,0-4.5H14a.75.75,0,0,1,0,1.5H11.5a.75.75,0,0,0,0,1.5h1a2.25,2.25,0,0,1,0,4.5Z" fill="#fff"></path>
                                <path d="M12 18.75a.7502.7502 0 0 1-.75-.75V16a.75.75 0 0 1 1.5 0v2A.7502.7502 0 0 1 12 18.75zM12 26.75a.7502.7502 0 0 1-.75-.75V24a.75.75 0 0 1 1.5 0v2A.7502.7502 0 0 1 12 26.75zM52 29.75A8.75 8.75 0 1 1 60.75 21 8.75967 8.75967 0 0 1 52 29.75zm0-16A7.25 7.25 0 1 0 59.25 21 7.258 7.258 0 0 0 52 13.75z" fill="#fff"></path>
                                <path d="M50 23.75a.75.75 0 0 1-.53027-1.28027L51.25 20.68945V16a.75.75 0 0 1 1.5 0v5a.75027.75027 0 0 1-.21973.53027l-2 2A.74671.74671 0 0 1 50 23.75zM52 13.75a.7502.7502 0 0 1-.75-.75V11a.75.75 0 0 1 1.5 0v2A.7502.7502 0 0 1 52 13.75zM57.5 15.25a.75.75 0 0 1-.53027-1.28027l1.5-1.5a.74992.74992 0 0 1 1.06054 1.06054l-1.5 1.5A.74671.74671 0 0 1 57.5 15.25z" fill="#fff"></path>
                                <path d="M60,14.75a.74671.74671,0,0,1-.53027-.21973l-2-2a.74992.74992,0,0,1,1.06054-1.06054l2,2A.75.75,0,0,1,60,14.75Z" fill="#fff"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
