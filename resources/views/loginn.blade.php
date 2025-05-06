@extends('layouts.app')

@section('content')

<div class="min-h-screen flex">
    <div class="relative container max-w-none items-center lg:items-stretch justify-center flex lg:grid lg:flex-col lg:grid-cols-2 lg:px-0">
        <div class="flex flex-col items-center justify-center w-full p-10 order-2 lg:order-1">
            <div class="flex items-center grow w-full max-w-[375px]">

                <form class="block w-full space-y-4">
                    
                    <div class="space-y-1.5 pb-3">
                        <h1 class="text-2xl font-semibold tracking-tight text-center">Sign in to Shoplit</h1>
                    </div>
                    
                    <div data-slot="alert" role="alert" class="flex items-stretch w-full group-[.toaster]:w-(--width) rounded-md px-3 py-2.5 gap-2 text-[0.8125rem] leading-[--text-sm--line-height] [&amp;>[data-slot=alert-icon]>svg]:size-4 *:data-alert-icon:mt-0.5 *:data-slot=alert-close:-me-0.5 [&amp;>[data-slot=alert-close]>svg]:size-3.5! bg-muted border border-border text-foreground">
                        
                        <div data-slot="alert-icon" class="shrink-0">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="remixicon text-primary"> 
                                <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11 15V17H13V15H11ZM11 7V13H13V7H11Z"></path>
                            </svg>
                        </div>
                        
                        <div data-slot="alert-title" class="grow tracking-tight text-accent-foreground">
                            Use <span class="text-mono font-semibold">demo@teogame.com</span> 
                            username and <span class="text-mono font-semibold">demo123</span> 
                            for demo access.
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-3.5">
                        <button data-slot="button" class="group focus-visible:outline-hidden inline-flex items-center justify-center has-[[data-arrow=true]]:justify-between whitespace-nowrap font-medium ring-offset-background transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:shrink-0 text-accent-foreground border border-input hover:bg-accent/50 data-[state=open]:bg-accent/50 h-10 rounded-md px-3 text-sm gap-2 [&amp;_svg]:size-4 focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 [&amp;_svg:not([role=img])]:opacity-60 shadow-xs shadow-black/5" type="button">
                            
                            <svg viewBox="10 10 30 30" class="size-4! opacity-100!">
                                
                                {{-- <path fill="currentColor" d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"></path> --}}
                            </svg> Sign in with Google
                        </button>
                    </div>
                    
                    <div class="relative py-1.5">
                        <div class="absolute inset-0 flex items-center">
                            <span class="w-full border-t"></span>
                        </div>
                        
                        <div class="relative flex justify-center text-xs uppercase">
                            <span class="bg-background px-2 text-muted-foreground">or</span>
                        </div>
                    </div>
                    
                    <div data-slot="form-item" class="flex flex-col gap-2.5" data-invalid="false">
                        <label data-slot="form-label" class="text-sm leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-50 font-medium text-foreground" for=":r0:-form-item">Email
                        </label><input data-slot="form-control" class="flex w-full bg-background border border-input shadow-xs shadow-black/5 transition-[color,box-shadow] text-foreground placeholder:text-muted-foreground/80 focus-visible:ring-ring/30 focus-visible:border-ring focus-visible:outline-none focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50 [&amp;[readonly]]:opacity-70 file:h-full [&amp;[type=file]]:py-0 file:border-solid file:border-input file:bg-transparent file:font-medium file:not-italic file:text-foreground file:p-0 file:border-0 file:border-e aria-invalid:border-destructive/60 aria-invalid:ring-destructive/10 dark:aria-invalid:border-destructive dark:aria-invalid:ring-destructive/20 h-10 px-3 py-2 text-sm rounded-lg file:pe-3 file:me-3" placeholder="Your email" id=":r0:-form-item" aria-describedby=":r0:-form-item-description" aria-invalid="false" value="demo@teogame.com" name="email">
                    </div>
                    
                    <div data-slot="form-item" class="flex flex-col gap-2.5" data-invalid="false">
                        
                        <div class="flex justify-between items-center gap-2.5">
                            <label data-slot="form-label" class="text-sm leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-50 font-medium text-foreground" for=":r1:-form-item">Password
                            </label>
                            
                            <a class="text-sm font-semibold text-foreground hover:underline hover:underline-offset-2" href="/reset-password">Forgot Password?</a>
                        
                        </div>
                        
                        <div class="relative"><input data-slot="input" class="flex w-full bg-background border border-input shadow-xs shadow-black/5 transition-[color,box-shadow] text-foreground placeholder:text-muted-foreground/80 focus-visible:ring-ring/30 focus-visible:border-ring focus-visible:outline-none focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50 [&amp;[readonly]]:opacity-70 file:h-full [&amp;[type=file]]:py-0 file:border-solid file:border-input file:bg-transparent file:font-medium file:not-italic file:text-foreground file:p-0 file:border-0 file:border-e aria-invalid:border-destructive/60 aria-invalid:ring-destructive/10 dark:aria-invalid:border-destructive dark:aria-invalid:ring-destructive/20 h-10 px-3 py-2 text-sm rounded-lg file:pe-3 file:me-3" placeholder="Your password" type="password" value="demo123" name="password">
                            
                            <button data-slot="button" class="group focus-visible:outline-hidden inline-flex items-center justify-center has-[[data-arrow=true]]:justify-between whitespace-nowrap font-medium ring-offset-background transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:shrink-0 text-accent-foreground hover:bg-accent hover:text-accent-foreground data-[state=open]:bg-accent data-[state=open]:text-foreground rounded-md text-[0.8125rem] leading-[1.385] gap-1.5 focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 p-0 [&amp;_svg]:size-4 absolute end-0 top-1/2 -translate-y-1/2 h-7 w-7 me-1.5 bg-transparent!" type="button" aria-label="Show password">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye text-muted-foreground">
                                    
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        
                        </div>
                    
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" data-slot="checkbox" class="group peer size-5 bg-background shrink-0 rounded-md border border-input ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 aria-invalid:border-destructive/60 aria-invalid:ring-destructive/10 dark:aria-invalid:border-destructive dark:aria-invalid:ring-destructive/20 [[data-invalid=true]_&amp;]:border-destructive/60 [[data-invalid=true]_&amp;]:ring-destructive/10 dark:[[data-invalid=true]_&amp;]:border-destructive dark:[[data-invalid=true]_&amp;]:ring-destructive/20 data-[state=checked]:bg-mono data-[state=checked]:border-mono data-[state=checked]:text-mono-foreground data-[state=indeterminate]:bg-mono data-[state=indeterminate]:border-mono data-[state=indeterminate]:text-mono-foreground" id="remember-me">
                        </button>
                        <input aria-hidden="true" style="transform: translateX(-100%); position: absolute; pointer-events: none; opacity: 0; margin: 0px; width: 20px; height: 20px;" tabindex="-1" type="checkbox" value="on">
                        
                        <label for="remember-me" class="text-sm leading-none text-muted-foreground">Remember me</label>
                    
                    </div>
                    
                    <div class="flex flex-col gap-2.5">
                        
                        <button data-slot="button" class="group focus-visible:outline-hidden inline-flex items-center justify-center has-[[data-arrow=true]]:justify-between whitespace-nowrap font-medium ring-offset-background transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:shrink-0 bg-mono text-mono-foreground hover:bg-mono-darker data-[state=open]:bg-mono-darker h-10 rounded-md px-3 text-sm gap-2 [&amp;_svg]:size-4 focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 shadow-xs shadow-black/5" type="submit">Continue
                        
                        </button>
                    </div>
                    
                    <p class="text-sm text-muted-foreground text-center">Don't have an account? 
                        <a class="text-sm font-semibold text-foreground hover:underline hover:underline-offset-2" href="/signup">Sign Up</a>
                    </p>
                </form>

            </div>
        </div>

        <div class="hidden lg:flex flex-col justify-between lg:rounded-xl lg:border lg:border-light lg:m-5 order-1 lg:order-2 bg-top xxl:bg-center xl:bg-cover bg-no-repeat branded-bg gap-y-8">

            <img class="h-full" src="{{ asset('images/board.png') }}" alt="Logo">

        </div>
    </div>
</div>