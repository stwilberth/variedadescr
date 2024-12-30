@if($title)
    <title>{{ $title }} | VariedadesCR.com</title>
    <meta property="og:title" content="{{ $title }} | VariedadesCR.com">
    <meta name="twitter:title" content="{{ $title }} | VariedadesCR.com">
@endif

@if($description)
    <meta name="description" content="{{ $description }}">
    <meta property="og:description" content="{{ $description }}">
    <meta name="twitter:description" content="{{ $description }}">
@endif

@if($image)
    <meta property="og:image" content="{{ $image }}">
    <meta property="og:image:secure_url" content="{{ $image }}">
    <meta name="twitter:image" content="{{ $image }}">
    <meta name="twitter:card" content="summary_large_image">
@endif

@if($publishedTime)
    <meta property="article:published_time" content="{{ $publishedTime }}">
@endif

@if($section)
    <meta property="article:section" content="{{ $section }}">
@endif

<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="VariedadesCR.com">
<meta property="og:url" content="{{ url()->current() }}">

@if($schema)
    <script type="application/ld+json">
        {!! json_encode($schema) !!}
    </script>
@endif 