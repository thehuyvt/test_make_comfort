@extends('customer.layout.master')
@section('content')
    <section class="bg-img1 txt-center p-lr-15 p-tb-92 m-t-100" style="background-image: url({{asset('customer/images/bg-01.jpg')}});">
        <h2 class="ltext-105 cl0 txt-center">
            Về chúng tôi
        </h2>
    </section>
    <section class="bg0 p-t-75 p-b-120">
        <div class="container">
            <div class="row p-b-148">
                <div class="col-md-7 col-lg-8">
                    <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                        <h3 class="mtext-111 cl2 p-b-16">
                            Về thương hiệu thời trang MakeComfort
                        </h3>

                        <p class="stext-113 cl6 p-b-26">
                            Ra đời từ 2024, thương hiệu thời trang MakeComfort xác định sứ mệnh giúp các bạn giới trẻ trở nên đẹp
                            và tự tin hơn vào bản thân mình. Ngày nay giới trẻ đang đứng những cơ hội tuyệt vời của
                            xã hội hiện đại, công nghệ thông tin phát triển, cuộc cách mạng của các trang mạng xã hội
                            để khẳng định bản thân. Bên cạnh đó, MakeComfort hiểu rằng người trẻ cũng đang phải đối diện
                            với những áp lực, thử thách thôi thúc bản thân phải thể hiện mình so với những người khác.
                        </p>

                        <p class="stext-113 cl6 p-b-26">
                            Thương hiệu thời trang MakeComfort cam kết mang đến những sản phẩm chất lượng cao, phù hợp với xu hướng thời trang hiện đại, nhưng vẫn giữ được sự thoải mái và tiện dụng. Chúng tôi luôn chú trọng đến việc lựa chọn chất liệu an toàn, thân thiện với môi trường và quy trình sản xuất bền vững nhằm bảo vệ hành tinh cho thế hệ tương lai.
                        </p>

                        <p class="stext-113 cl6 p-b-26">
                            Chúng tôi cũng không ngừng nỗ lực cải tiến và sáng tạo, không chỉ trong thiết kế sản phẩm mà còn trong cách thức tiếp cận và phục vụ khách hàng. MakeComfort mong muốn trở thành người bạn đồng hành đáng tin cậy của giới trẻ, giúp họ không chỉ tỏa sáng trong phong cách mà còn cảm thấy được hỗ trợ và đồng hành trên hành trình chinh phục những ước mơ và hoài bão của mình.
                        </p>

                        <p class="stext-113 cl6 p-b-26">
                            Hãy để MakeComfort cùng bạn bước qua những thử thách và tỏa sáng trong mọi khoảnh khắc của cuộc sống!
                        </p>

                    </div>
                </div>

                <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                    <div class="how-bor1 ">
                        <div class="hov-img0">
                            <img src="{{asset('customer/images/about-01.jpg')}}" alt="IMG">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="order-md-2 col-md-7 col-lg-8 p-b-30">
                    <div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
                        <h3 class="mtext-111 cl2 p-b-16">
                            Sứ mệnh
                        </h3>

                        <p class="stext-113 cl6 p-b-26">
                            Thương hiệu thời trang MakeComfort ra đời với mong muốn được đồng hành, truyền cảm hứng và
                            khuyến khích các bạn trẻ dám bước ra khỏi vùng an toàn để tự do, tự tin thể
                            hiện chính mình theo phong cách phù hợp với bản thân. Chính vì thế hệ thống thời trang
                            MakeComfort đầu tư tâm huyết nghiên cứu thiết kế chi tiết từng sản phẩm để có thể mang lại
                            những trải nghiệm mới cho khách hàng, cũng là thông điệp muốn nhắn nhủ đến các bạn trẻ
                            hãy cho bản thân trải nghiệm, dám thay đổi, bứt phá để vươn lên.
                        </p>

                        <p class="stext-113 cl6 p-b-26">
                            Chúng ta chỉ thực sự thay đổi khi chúng ta hành động. MakeComfort tin rằng dù có thể thành công hay thất bại, nhưng chắc chắn chỉ có những trải nghiệm mới giúp bạn trưởng thành. Trưởng thành là một hành trình với những dấu mốc thanh xuân, để khi nhìn lại tôi và bạn có thể tự tin không phải nuối tiếc “giá như…”
                        </p>

                        <div class="bor16 p-l-29 p-b-9 m-t-22">
                            <p class="stext-114 cl6 p-r-40 p-b-11">
                                MakeComfort tin rằng mỗi bạn trẻ là một phiên bản độc đáo và duy nhất.
                            </p>

                            <span class="stext-111 cl8">
                                - MakeComfort
							</span>
                        </div>
                    </div>
                </div>

                <div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
                    <div class="how-bor2">
                        <div class="hov-img0">
                            <img src="{{asset('customer/images/about-02.jpg')}}" alt="IMG">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
