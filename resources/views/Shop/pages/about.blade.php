@extends('layouts.shop')

@section('title', 'About Us - ')

@section('content')
    <div class="max-w-7xl mx-auto px-6 md:px-12 pt-32 pb-24 md:pt-40 md:pb-32 min-h-screen">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20 items-center">
            
            {{-- Image Side --}}
            <div class="w-full relative h-[600px] bg-gray-100 dark:bg-neutral-800 overflow-hidden shadow-lg">
                {{-- Placeholder image, replace with exact asset --}}
                <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=1000&q=80" 
                     alt="About Snap Fashion" 
                     class="w-full h-full object-cover">
            </div>

            {{-- Text Side --}}
            <div class="flex flex-col justify-center py-6 md:py-12 pr-0 lg:pr-12">
                <span class="text-sm text-gray-400 dark:text-gray-500 tracking-[0.2em] uppercase mb-4 block font-body">Our Story</span>
                
                <h1 class="font-display text-4xl md:text-5xl lg:text-6xl text-gray-900 dark:text-cream mb-8">
                    About Us
                </h1>
                
                <p class="text-sm md:text-base text-gray-700 dark:text-sand leading-[1.8] tracking-widest uppercase font-body">
                    SNAP FASHION APPAREL IS WHERE TIMELESS
                    ELEGANCE MEETS MODERN SOPHISTICATION. EVERY
                    PIECE IS CRAFTED WITH THE FINEST ATTENTION TO
                    DETAIL, DESIGNED TO BRING COMFORT, CONFIDENCE,
                    AND EFFORTLESS STYLE. MORE THAN CLOTHING, IT'S A
                    STATEMENT OF GRACE AND LUXURY, CREATED FOR
                    THOSE WHO VALUE SUBTLE REFINEMENT AND
                    ENDURING BEAUTY
                </p>
            </div>
            
        </div>

    </div>
@endsection
