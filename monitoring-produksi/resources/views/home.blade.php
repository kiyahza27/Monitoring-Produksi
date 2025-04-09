<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="icon" href="{{ asset('images/logoround.png') }}" type="image/png">
    <title>Kocollection</title>
  </head>
  <body>
    <!-- header-->
    <header class="bg-black/90 sticky top-0">
      <nav data-aos="fade-down" data-aos-duration="1000" class="text-white w-11/12 md:container mx-auto py-4 flex justify-between items-center">
        <a href="" class="text-3xl font-bold">Kocollection</a>
        <ul class="menu hidden md:flex">
          <li class="px-5 py-1 hover:text-amber-400 underline underline-offset-8"><a href="#home">Home</a></li>
          <li class="px-5 py-1 hover:text-amber-400 hover:underline underline-offset-8"><a href="#layanan">Layanan Kami</a></li>
          <li class="px-5 py-1 hover:text-amber-400 hover:underline underline-offset-8"><a href="#katalog">Katalog</a></li>
          <li class="px-5 py-1 hover:text-amber-400 hover:underline underline-offset-8"><a href="#carapesan">Cara Pesan</a></li>
          <li class="px-5 py-1 hover:text-amber-400 hover:underline underline-offset-8"><a href="#about">Tentang Kami</a></li>
        </ul>
        <button class="hamburger-menu text-2xl md:hidden absolute right-4">
          <i class="fa-solid fa-bars"></i>
          <i class="fa-solid fa-xmark hidden"></i>
        </button>
        <button class="px-7 py-1 hover:text-amber-400 md:hover:text-white"><a href="{{ route('filament.admin.auth.login') }}" class="md:border-2 md:border-amber-600 md:py-2 md:px-5 md:rounded-3xl md:hover:bg-amber-600 text-white">Admin Login</a></button>
      </nav>
    </header>

    <!-- hero -->
    <section id="home" class="bg-[url('https://images.unsplash.com/photo-1633655442136-bbc120229009?q=80&w=1476&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-no-repeat bg-cover">
      <div class="mx-auto text-center text-white h-screen bg-black/80 flex items-center">
        <div class="mx-auto w-3/4 md:w-2/4">
          <h3 data-aos="zoom-in-down" data-aos-duration="1400" class="text-5xl font-bold text-center mb-8">KOCOLLECTION</h3>
          <h5 data-aos="zoom-in-down" data-aos-duration="1400" class="text-3xl font-semibold text-center">Jasa Konveksi Seragam Pakaian Muslim Pria</h5>
          <h5 data-aos="zoom-in-down" data-aos-duration="1400" class="text-3xl font-semibold text-center mb-8">Baju Koko, Gamis, Jubah, Jas</h5>
          <button data-aos="fade-up" data-aos-duration="2000" onclick="window.open('https://wa.me/6281298999965')" class="bg-amber-700 text-white py-4 px-6 rounded-full hover:bg-amber-950 transition ease-in-out delay-15 hover:-translate-y-1 hover:scale-110 duration-150">PESAN SEKARANG
            <i class="fa-brands fa-whatsapp"></i>
          </button>
        </div>
      </div>
    </section>

    <!-- layanan kami -->
    <section id="layanan" class="bg-gray-200 py-20">
      <div data-aos="fade-up" data-aos-duration="1000" class="w-11/12 md:container mx-auto">
        <h3 class="text-5xl font-bold text-center mb-8">Layanan Kami</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- layanan 1-->
          <div data-aos="fade-up" data-aos-duration="1000" class="flex flex-col md:flex-row py-8 px-8 md:px-8 bg-white rounded-xl items-start">
            <img src="{{ asset('images/pakaian.jpg') }}" class="w-full md:w-1/2 h-auto object-cover"/>
            <div class="flex-1 mt-4 md:mt-0 md:pl-5">
              <h4 class="text-2xl font-bold mb-5">Produksi Pakaian</h4>
              <p class="text-gray-500 mb-5 text-justify">Kocollection menyediakan layanan produksi pakaian berkualitas tinggi yang dirancang untuk memenuhi berbagai kebutuhan pelanggan.</p>
            </div>
          </div>

          <!-- layanan 2-->
          <div data-aos="fade-up" data-aos-duration="1000" class="flex flex-col md:flex-row py-8 px-8 md:px-8 bg-white rounded-xl items-start">
            <img src="{{ asset('images/jahit.jpg') }}" class="w-full md:w-1/2 h-auto object-cover"/>
            <div class="flex-1 mt-4 md:mt-0 md:pl-5">
              <h4 class="text-2xl font-bold mb-5">Permak Pakaian</h4>
              <p class="text-gray-500 mb-5 text-justify">Kocollection menawarkan layanan permak pakaian yang profesional dan terpercaya untuk memperbaiki atau mengubah ukuran pakaian agar lebih sesuai dengan bentuk tubuh. </p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- katalog -->
    <section id="katalog" class="py-20 bg-white">
      <h3 data-aos="fade-up" data-aos-duration="1500" class="text-5xl font-bold text-center mb-8">Katalog</h3>
      <div data-aos="fade-up" data-aos-duration="1500" class="grid grid-cols-2 md:grid-cols-4 w-11/12 md:container mx-auto gap-6">
        <!-- katalog 1-->
        <div class="shadow-xl transition ease-in-out delay-15 hover:-translate-y-1 hover:scale-110 duration-150">
          <a href="">
            <img src="https://down-id.img.susercontent.com/file/id-11134207-7qul1-lf96thab64se03" class="w-full" />
            <div class="py-3 px-5">
              <h4 class="text-center font-bold">Website 1</h4>
            </div>
          </a>
        </div>
        <!-- katalog 2-->
        <div class="shadow-xl transition ease-in-out delay-15 hover:-translate-y-1 hover:scale-110 duration-150">
          <a href="">
            <img src="https://down-id.img.susercontent.com/file/id-11134207-7qula-lfhty3xnvwqi0c" class="w-full" />
            <div class="py-3 px-5">
              <h4 class="text-center font-bold">Website 2</h4>
            </div>
          </a>
        </div>
        <!-- katalog 3-->
        <div class="shadow-xl transition ease-in-out delay-15 hover:-translate-y-1 hover:scale-110 duration-150">
          <a href="">
            <img src="https://down-id.img.susercontent.com/file/sg-11134201-23010-t93y5mzrxdmv35_tn" class="w-full" />
            <div class="py-3 px-5">
              <h4 class="text-center font-bold">Website 3</h4>
            </div>
          </a>
        </div>
        <!-- katalog 4-->
        <div class="shadow-xl transition ease-in-out delay-15 hover:-translate-y-1 hover:scale-110 duration-150">
          <a href="">
            <img src="https://down-id.img.susercontent.com/file/sg-11134201-23010-0lf9xexrxdmv34_tn" class="w-full" />
            <div class="py-3 px-5">
              <h4 class="text-center font-bold">Website 4</h4>
            </div>
          </a>
        </div>
        <!-- katalog 5-->
        <div class="shadow-xl transition ease-in-out delay-15 hover:-translate-y-1 hover:scale-110 duration-150">
          <a href="">
            <img src="https://img.ws.mms.shopee.co.id/c1c447618477a0fb3c85dc7fc4e93d10" class="w-full" />
            <div class="py-3 px-5">
              <h4 class="text-center font-bold">Website 5</h4>
            </div>
          </a>
        </div>
        <!-- katalog 6-->
        <div class="shadow-xl transition ease-in-out delay-15 hover:-translate-y-1 hover:scale-110 duration-150">
          <a href="">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR97Xk3bUvwKWob18w8vxc66u66WH3aBJbXYA&s" class="w-full" />
            <div class="py-3 px-5">
              <h4 class="text-center font-bold">Website 6</h4>
            </div>
          </a>
        </div>
        <!-- katalog 7-->
        <div class="shadow-xl transition ease-in-out delay-15 hover:-translate-y-1 hover:scale-110 duration-150">
          <a href="">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS2kXX6k03amvg5tpHq7CfatNpGUavlb7VFbA&s" class="w-full" />
            <div class="py-3 px-5">
              <h4 class="text-center font-bold">Website 7</h4>
            </div>
          </a>
        </div>
        <!-- katalog 8-->
        <div class="shadow-xl transition ease-in-out delay-15 hover:-translate-y-1 hover:scale-110 duration-150">
          <a href="">
            <img src="https://down-id.img.susercontent.com/file/id-11134207-7r98s-lsh3rexkj6lw3a" class="w-full" />
            <div class="py-3 px-5">
              <h4 class="text-center font-bold">Website 8</h4>
            </div>
          </a>
        </div>
      </div>
    </section>
    
    <!-- Cara Pesan -->
    <section id="carapesan" class="bg-gray-200 py-20">
      <div data-aos="fade-up" data-aos-duration="1000" class="w-11/12 md:container mx-auto">
        <h3 class="text-5xl font-bold text-center mb-8">Cara Pesan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Cara 1-->
          <div data-aos="fade-up" data-aos-duration="1000" class="flex space-x-5 py-8 px-8 bg-white rounded-xl items-start">
            <img src="{{ asset('images/pemesanan.png') }}" class="w-16 md:w-1/5"/>
            <div>
              <h4 class="text-2xl font-bold mb-5">1. Konsultasi dan Pemesanan</h4>
              <p class="text-gray-500 mb-5 text-justify">Konsultasi dan pemesanan dapat dilakukan secara online via whatsapp ataupun secara offline dengan datang langsung ke lokasi konveksi.</p>
            </div>
          </div>

          <!-- Cara 2-->
          <div data-aos="fade-up" data-aos-duration="1000" class="flex space-x-5 py-8 px-8 bg-white rounded-xl items-start">
            <img src="{{ asset('images/pembayaran.png') }}" class="w-16 md:w-1/5"/>
            <div>
              <h4 class="text-2xl font-bold mb-5">2. Pembayaran</h4>
              <p class="text-gray-500 mb-5 text-justify">Melakukan pembayaran melalui transfer bank atau pembayaran tunai setelah melakukan pemesanan.</p>
            </div>
          </div>

          <!-- Cara 3-->
          <div data-aos="fade-up" data-aos-duration="1000" class="flex space-x-5 py-8 px-8 bg-white rounded-xl items-start">
            <img src="{{ asset('images/produksi.png') }}" class="w-16 md:w-1/5"/>
            <div>
              <h4 class="text-2xl font-bold mb-5">3. Proses Produksi</h4>
              <p class="text-gray-500 mb-5 text-justify">Menunggu proses produksi pesanan hingga selesai.</p>
            </div>
          </div>

          <!-- Cara 4-->
          <div data-aos="fade-up" data-aos-duration="1000" class="flex space-x-5 py-8 px-8 bg-white rounded-xl items-start">
            <img src="{{ asset('images/pengiriman.png') }}" class="w-16 md:w-1/5"/>
            <div>
              <h4 class="text-2xl font-bold mb-5">4. Pengiriman</h4>
              <p class="text-gray-500 mb-5 text-justify">Pesanan selesai dikemas dan siap untuk diambil atau dikirim.</p>
            </div>
          </div>
        </div>
      </div>
    </section>    
    
    <!-- about -->
    <section id="about" class="w-11/12 md:container mx-auto py-20">
      <div data-aos="fade-up" data-aos-duration="1500" class="flex flex-col md:flex-row space-y-10 md:space-y-0 md:space-x-10 items-start">
        <img src="{{ asset('images/logoround.png') }}" class="w-24 md:w-1/3" />
        <div>
          <h3 class="text-5xl font-bold mb-5">TENTANG KOCOLLECTION</h3>
          <p class="mb-5 pb-5 border-b border-gray-900 text-justify">Kocollection adalah usaha konveksi yang melayani jasa perbaikan dan pembuatan pakaian.
          Kocollection melayani pembuatan berbagai kebutuhan seragam pakaian khususnya baju koko, gamis, jubah, jas, atupun kemeja untuk kebutuhan seragam perusahaan, komunitas, organisasi, lembaga pendidikan, dan lainya.
          Kocollection berkomitmen untuk menghadirkan produk berkualitas tinggi dengan harga terjangkau. 
          </p>
          <ul class="md:flex md:space-x-5">
            <li>
              <a href="https://wa.me/6281298999965" target="_blank"><i class="fa-brands fa-whatsapp"></i>  081298999965</a>
            </li>
            <li>
              <a href=""><i class="fa-solid fa-envelope"></i> warsuardi1@gmail.com</a>
            </li>
            <li>
              <a href=""><i class="fa-solid fa-location-dot"></i> Jalan Raya Penggilingan PIK RT.06, RW. 06, Cakung, Jakarta Timur</a>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <footer class="py-5 text-center font-bold">&copy; 2024 Kocollection</footer>

    <script src="script.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init({
        offset:1,
      });
    </script>
  </body>
</html>