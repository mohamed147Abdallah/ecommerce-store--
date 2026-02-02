<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Collection - MyStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;700;900&display=swap');
        
        body { font-family: 'Outfit', sans-serif; }
        
        .glass { 
            background: rgba(15, 15, 15, 0.7); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08); 
        }

        .glass-strong {
            background: rgba(5, 5, 5, 0.9);
            backdrop-filter: blur(30px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .text-stroke {
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.3);
            color: transparent;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #050505; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        /* --- Optimized Entrance Animations --- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-entry {
            opacity: 0;
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: transform, opacity;
        }

        .delay-100 { animation-delay: 0.05s; }
        .delay-200 { animation-delay: 0.1s; }
        .delay-300 { animation-delay: 0.15s; }
        .delay-500 { animation-delay: 0.25s; }
        .delay-700 { animation-delay: 0.35s; }
    </style>
</head>
<body class="bg-[#050505] text-gray-200 antialiased selection:bg-white selection:text-black overflow-x-hidden">

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-5 right-5 z-[100] transform translate-x-full opacity-0 transition-all duration-500 cubic-bezier(0.175, 0.885, 0.32, 1.275)">
        <div class="glass px-6 py-4 flex items-center gap-4 border-l-2 border-white">
            <div class="text-white animate-pulse">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs uppercase tracking-widest text-white">Success</h4>
                <p class="text-[10px] text-gray-400 uppercase tracking-wide" id="toast-message">Item added to cart!</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- Sidebar Navigation (Static) -->
        <nav class="fixed bottom-0 md:top-0 md:left-0 w-full md:w-24 md:h-screen h-16 glass-strong z-50 flex md:flex-col justify-between items-center py-0 md:py-8 px-6 md:px-0 md:border-r md:border-t-0 border-t border-white/5">
            
            <!-- Logo Icon -->
            <a href="<?php echo e(route('home')); ?>" class="hidden md:flex w-10 h-10 bg-white text-black items-center justify-center font-black text-xl hover:scale-110 transition-transform duration-300">
                M
            </a>

            <!-- Nav Links -->
            <div class="flex md:flex-col justify-around w-full md:w-auto md:gap-10 items-center">
                <a href="<?php echo e(route('home')); ?>" class="text-gray-500 hover:text-white transition-colors duration-300 flex flex-col items-center gap-1 group">
                    <i class="fas fa-home text-lg group-hover:-translate-y-1 transition-transform"></i>
                    <span class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6">Home</span>
                </a>
                
                <a href="<?php echo e(route('products.index')); ?>" class="text-white hover:text-blue-400 transition-colors duration-300 flex flex-col items-center gap-1 group">
                    <i class="fas fa-layer-group text-lg group-hover:-translate-y-1 transition-transform"></i>
                    <span class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6">Shop</span>
                </a>

                <!-- Profile Link (Added as requested) -->
                <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('profile.index')); ?>" class="text-gray-500 hover:text-white transition-colors duration-300 flex flex-col items-center gap-1 group">
                    <i class="fas fa-user text-lg group-hover:-translate-y-1 transition-transform"></i>
                    <span class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6">Profile</span>
                </a>
                <?php endif; ?>

               

                <!-- Mobile Cart -->
                <a href="<?php echo e(route('cart.index')); ?>" class="relative group cursor-pointer md:hidden">
                    <span class="absolute -top-1 -right-1 bg-white text-black text-[9px] font-bold w-3 h-3 flex items-center justify-center rounded-sm">
                        <?php echo e(session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0); ?>

                    </span>
                    <i class="fas fa-shopping-bag text-gray-500 group-hover:text-white transition-colors"></i>
                </a>
            </div>

            <!-- Bottom Actions -->
            <div class="hidden md:flex flex-col gap-6 items-center">
                <a href="<?php echo e(route('cart.index')); ?>" class="relative group cursor-pointer">
                    <span id="cart-badge" class="absolute -top-2 -right-2 bg-white text-black text-[9px] font-bold w-4 h-4 flex items-center justify-center">
                        <?php echo e(session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0); ?>

                    </span>
                    <i class="fas fa-shopping-bag text-xl text-gray-400 group-hover:text-white transition"></i>
                </a>
                
                <!-- Auth / Profile Avatar -->
                <?php if(auth()->guard()->check()): ?>
                    <div class="relative group">
                        <a href="<?php echo e(route('profile.index')); ?>" class="block">
                            <div class="w-8 h-8 rounded-full bg-neutral-800 border border-white/20 flex items-center justify-center text-xs font-bold text-white uppercase hover:border-white transition cursor-pointer">
                                <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                            </div>
                        </a>
                        
                        <!-- Hover Menu -->
                        <div class="absolute left-full bottom-0 ml-4 mb-[-10px] w-48 bg-black border border-white/10 p-4 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 z-50 glass">
                             <p class="text-sm text-white font-bold truncate"><?php echo e(Auth::user()->name); ?></p>
                             <p class="text-[10px] text-gray-500 uppercase mb-3 truncate"><?php echo e(Auth::user()->email); ?></p>
                             
                             <?php if(Auth::user()->is_admin): ?>
                                <a href="<?php echo e(route('products.create')); ?>" class="block text-xs font-bold text-blue-400 hover:text-white mb-2 uppercase"><i class="fas fa-plus mr-1"></i> Add Product</a>
                             <?php endif; ?>
                             
                             <a href="<?php echo e(route('profile.index')); ?>" class="block text-xs font-bold text-gray-400 hover:text-white mb-2 uppercase">My Profile</a>

                             <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-xs font-bold text-red-500 hover:text-white uppercase w-full text-left">Logout</button>
                             </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition"><i class="fas fa-user text-xs"></i></a>
                <?php endif; ?>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-24 relative min-h-screen flex flex-col">
            
            <!-- Search Overlay -->
            <div id="search-overlay" class="fixed inset-0 bg-black/95 z-[60] hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300">
                <button onclick="toggleSearch()" class="absolute top-10 right-10 text-white text-2xl hover:rotate-90 transition-transform"><i class="fas fa-times"></i></button>
                <h2 class="text-white/50 font-bold uppercase tracking-[0.3em] text-sm mb-4">Type to search</h2>
                <form action="<?php echo e(route('search')); ?>" method="GET" class="w-full flex justify-center">
                    <input type="text" name="query" value="<?php echo e(request('query')); ?>" placeholder="WHAT ARE YOU LOOKING FOR?" class="bg-transparent border-b-2 border-white/20 text-white text-2xl md:text-5xl font-black uppercase placeholder-white/10 focus:outline-none focus:border-white w-3/4 text-center py-4">
                </form>
            </div>

            <!-- Background Gradient (Subtle) -->
            <div class="fixed inset-0 z-[-1] pointer-events-none">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-900/10 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-900/5 rounded-full blur-[100px]"></div>
            </div>

            <div class="flex-1 max-w-[1600px] mx-auto w-full px-6 md:px-12 py-12 md:py-20">
                <div class="flex flex-col lg:flex-row gap-12">
                    
                    <!-- Sidebar Filter (Fixed/Sticky) -->
                    <aside class="w-full lg:w-64 flex-shrink-0 animate-entry delay-100">
                        <div class="sticky top-12">
                            <h3 class="font-black text-2xl mb-8 text-white uppercase tracking-tighter">
                                Collections
                            </h3>
                            
                            <ul class="space-y-1 border-l border-white/10 pl-6">
                                <li>
                                    <a href="<?php echo e(route('products.index')); ?>" 
                                       class="block py-2 text-sm font-bold uppercase tracking-widest transition-all duration-300 <?php echo e(request()->routeIs('products.index') && !request()->route('category') ? 'text-white translate-x-2' : 'text-gray-500 hover:text-white hover:translate-x-2'); ?>">
                                        All Products <span class="text-[9px] align-top opacity-50"><?php echo e($products->total()); ?></span>
                                    </a>
                                </li>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(route('category.show', $category->id)); ?>" 
                                           class="block py-2 text-sm font-bold uppercase tracking-widest transition-all duration-300 <?php echo e((isset($currentCategory) && $currentCategory->id == $category->id) || request()->route('id') == $category->id ? 'text-white translate-x-2' : 'text-gray-500 hover:text-white hover:translate-x-2'); ?>">
                                            <?php echo e($category->name); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>

                            <!-- Promo Box (Sharp) -->
                            <div class="mt-12 border border-white/10 p-6 bg-white/5 backdrop-blur-sm relative overflow-hidden group rounded-xl">
                                <div class="absolute -right-4 -top-4 w-12 h-12 bg-white rounded-full blur-xl opacity-20 group-hover:opacity-40 transition"></div>
                                <h4 class="text-white font-black uppercase tracking-widest text-sm mb-2 relative z-10">Summer Sale</h4>
                                <p class="text-gray-400 text-xs mb-6 relative z-10">Up to 50% off selected items. Limited time only.</p>
                                <button class="w-full border border-white text-white text-xs font-bold uppercase py-3 hover:bg-white hover:text-black transition relative z-10">
                                    View Offers
                                </button>
                            </div>
                        </div>
                    </aside>

                    <!-- Main Grid -->
                    <div class="flex-1">
                        <!-- Header -->
                        <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-b border-white/10 pb-6 animate-entry delay-200">
                            <div>
                                <p class="text-blue-500 text-xs font-bold uppercase tracking-[0.2em] mb-2">Premium Selection</p>
                                <h1 class="text-5xl font-black text-white mb-2 uppercase tracking-tighter">
                                    <?php if(isset($currentCategory)): ?>
                                        <?php echo e($currentCategory->name); ?>

                                    <?php elseif(request('query')): ?>
                                        Search: "<?php echo e(request('query')); ?>"
                                    <?php else: ?>
                                        All Products
                                    <?php endif; ?>
                                </h1>
                            </div>
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-4 md:mt-0">
                                Showing <span class="text-white"><?php echo e($products->count()); ?></span> Results
                            </div>
                        </div>

                        <!-- Product Grid (Updated Style) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-x-6 gap-y-12 animate-entry delay-300">
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="group">
                                    <!-- Image Card with Rounded Corners -->
                                    <div class="relative aspect-[3/4] bg-[#0a0a0a] border border-white/5 overflow-hidden mb-4 rounded-3xl">
                                        
                                        <!-- Admin Actions (Top Right - Overlay) -->
                                        <?php if(auth()->guard()->check()): ?>
                                            <?php if(auth()->user()->is_admin): ?>
                                                <div class="absolute top-4 right-4 z-20 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0">
                                                     <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="w-8 h-8 bg-white text-black rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition shadow-lg">
                                                        <i class="fas fa-pen text-xs"></i>
                                                    </a>
                                                    <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" onsubmit="return confirm('Delete item?');">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button class="w-8 h-8 bg-neutral-800 text-white border border-white/20 rounded-full flex items-center justify-center hover:bg-red-600 hover:border-red-600 transition shadow-lg">
                                                            <i class="fas fa-trash text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <!-- Clickable Image Link -->
                                        <a href="<?php echo e(route('products.show', $product->id)); ?>" class="block w-full h-full">
                                            <img src="<?php echo e($product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x600/1a1a1a/333333?text=Product'); ?>"
                                                 class="w-full h-full object-cover transition duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100"
                                                 alt="<?php echo e($product->name); ?>">
                                        </a>

                                        <!-- Quick Add Overlay (Slide Up) -->
                                        <div class="absolute bottom-0 left-0 w-full p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-black/60 backdrop-blur-md border-t border-white/10">
                                            <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="add-to-cart-form">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="w-full text-white text-xs font-bold uppercase flex justify-between items-center hover:text-blue-400 transition">
                                                    Add to Cart <i class="fas fa-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Product Info (Below Card) -->
                                    <div>
                                        <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">
                                            <?php if($product->category): ?>
                                                <!-- Category Link -->
                                                <a href="<?php echo e(route('home', ['category' => $product->category->id])); ?>#shop" class="hover:text-white transition-colors">
                                                    <?php echo e($product->category->name); ?>

                                                </a>
                                            <?php else: ?>
                                                Collection
                                            <?php endif; ?>
                                        </p>
                                        <div class="flex justify-between items-start">
                                            <!-- Product Name Link -->
                                            <h3 class="text-sm font-bold text-white uppercase tracking-wide truncate pr-4">
                                                <a href="<?php echo e(route('products.show', $product->id)); ?>"><?php echo e($product->name); ?></a>
                                            </h3>
                                            <span class="text-sm font-bold text-white">$<?php echo e($product->price); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-span-full py-32 text-center border border-dashed border-neutral-800 rounded-lg">
                                    <h3 class="text-2xl font-bold text-white mb-2 uppercase tracking-widest">No products found</h3>
                                    <p class="text-gray-500 text-sm">We couldn't find what you're looking for.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-20 border-t border-white/10 pt-8 flex justify-center animate-entry delay-500">
                            <?php echo e($products->links()); ?> 
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="border-t border-white/10 mt-auto bg-black pt-16 pb-32 md:pb-16 px-6 md:px-16 animate-entry delay-500">
                <div class="flex flex-col md:flex-row justify-between items-start gap-12">
                    <div class="max-w-xs">
                        <h4 class="text-2xl font-black text-white mb-6 tracking-tighter">MYSTORE.</h4>
                        <p class="text-gray-500 text-xs leading-loose">
                            Crafting the future of retail through minimalist design and superior quality materials.
                        </p>
                    </div>
                    <div class="w-full md:w-auto">
                        <h5 class="text-white text-[10px] font-bold uppercase tracking-widest mb-6">Newsletter</h5>
                        <div class="flex border-b border-white/20 py-2">
                            <input type="email" placeholder="ENTER EMAIL" class="bg-transparent border-none text-white text-xs font-bold uppercase w-full focus:outline-none placeholder-gray-700">
                            <button class="text-white hover:text-blue-500 transition"><i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        function toggleSearch() {
            const overlay = document.getElementById('search-overlay');
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                overlay.style.display = 'flex';
                setTimeout(() => { overlay.classList.remove('opacity-0'); }, 10);
            } else {
                overlay.classList.add('opacity-0');
                setTimeout(() => { overlay.classList.add('hidden'); overlay.style.display = 'none'; }, 300);
            }
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').innerText = message;
            toast.classList.remove('translate-x-full', 'opacity-0');
            setTimeout(() => { toast.classList.add('translate-x-full', 'opacity-0'); }, 3000);
        }

        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                const btn = this.querySelector('button');
                const originalContent = btn.innerHTML;
                
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'; 

                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => { if (response.ok) return response.text(); throw new Error('Err'); })
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newCount = doc.querySelector('#cart-badge') ? doc.querySelector('#cart-badge').innerText.trim() : null;
                    if(newCount) {
                         document.querySelectorAll('#cart-badge, .md\\:hidden span').forEach(el => el.innerText = newCount);
                    }
                    showToast('Item added to cart successfully!');
                })
                .catch(error => { showToast('Something went wrong!'); })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                });
            });
        });
    </script>
</body>
</html><?php /**PATH C:\Users\ASUS\OneDrive\Desktop\laravel\ecommerce-store\resources\views/products/index.blade.php ENDPATH**/ ?>