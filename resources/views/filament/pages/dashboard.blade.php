<x-filament::page>
    <x-filament::section>
        <div class="app-content content mt-4">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row"></div>
                <div class="content-body">
                    <!-- Dashboard Analytics Start -->
                    <section id="dashboard-analytics">
                        <div class="row match-height justify-content-center">
                            <!-- Greetings Card starts -->

                            <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center">
                                <div class="card shadow-lg border-0 rounded-lg">
                                    <div class="card-header py-3 bg-primary text-white">
                                        <h6 class="m-0 font-weight-bold">{{ __('المقدمة') }}</h6>
                                    </div>
                                    <div class="card-body animate__animated animate__bounce p-4">
                                        <div class="d-flex justify-content-center mb-4">
                                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 rounded-circle shadow"
                                                style="width: 25rem; filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.68));"
                                                src="{{ asset('hotel.png') }}" alt="...">
                                        </div>
                                        <div class="text-justify">
                                            <p class="mb-3">
                                                {{ __('منذ انطلاق نظام الحجز الخاص بنا، نسعى لتقديم تجربة حجز فندقي سهلة وآمنة تضمن للعملاء الراحة والثقة الكاملة أثناء حجز إقامتهم.') }}
                                            </p>
                                            <p class="mb-3">
                                                {{ __('نظامنا معتمد من شركات فندقية رسمية، ويخدم العملاء منذ عام 2013، مما يعكس خبرتنا في تقديم حلول تقنية عالية الجودة لقطاع الضيافة.') }}
                                            </p>
                                            <p class="mb-4">
                                                {{ __('نقدم خدمات متكاملة تشمل حجز الغرف، إدارة التوافر، الدفع الإلكتروني، وتأكيد الحجز الفوري.') }}
                                            </p>

                                            <x-filament::link href="#">
                                                &rarr; {{ __('للمزيد عن نظام الحجز، يمكنك زيارة موقعنا الرسمي') }}
                                            </x-filament::link>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Greetings Card ends -->
                        </div>
                    </section>
                    <!-- Dashboard Analytics end -->
                </div>
            </div>
        </div>
        <style>
            :root {
                --c-400: 34, 139, 34;
                /* Example RGB value for dark green */
                --tw-text-opacity: 1;
                /* Example opacity value */
            }

            .fi-section-content-ctn {
                margin-top: 20px;
            }

            h6.m-0.font-weight-bold {
                color: #817dbf
            }
        </style>

    </x-filament::section>

</x-filament::page>
