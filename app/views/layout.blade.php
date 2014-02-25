 <html lang="en">
     <head>
        @section('head')
         <meta charset="UTF-8" />
         <title>
             Tutorial
         </title>
         <link type="text/css" rel="stylesheet" href="{{ asset('css/layout.css') }}" />
         @show
     </head>
     <body>
         @include("header")
         <div class="content">
             <div class="container">
                 @yield("content")
             </div>
         </div>
         @include("footer")
         @section('scripts')
         <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
         @show
     </body>
 </html>

