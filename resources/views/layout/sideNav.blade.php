
<!--**********************************
    Sidebar start
***********************************-->
<style>
    .quixnav, .nav-label{
        font-size :18px;
    }
</style>
<div class="quixnav" >
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            @if(Auth::check())
                @if(Auth::user()->role === "shop")
                    <li class="nav-label first" style="font-size :18px;">Main Menu</li>
                    <li>
                        <a href="{{route('shop.dashBoard')}}">
                            <i class="icon icon-single-04"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    @if(Auth::user()->role == "shop" && Auth::user()->id===18)
                        <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                    class="icon icon-form"></i><span class="nav-text">Bank</span></a>
                            <ul aria-expanded="false">
                                <li><a href="{{route('shop.balance.form')}}">Form</a></li>
                                <li><a href="{{route('shop.balance.list')}}">Bank List</a></li>
                            </ul>
                        </li>
                    @endif
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-form"></i><span class="nav-text">Create ID</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('shop.user.form')}}">Form</a></li>
                            <li><a href="{{route('shop.user.list')}}">User List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon icon-app-store"></i>
                            <span class="nav-text">Transaction Details</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('shop.cash.form')}}">Transaction Form</a></li>
                            <li><a href="{{route('shop.cash.depositDetailList')}}">Deposit Transaction List</a></li>
                            <li><a href="{{route('shop.cash.withdrawalDetailList')}}">Withdrawal Transaction List</a></li>
                            <li><a href="{{route('shop.cash.expenseDetailList')}}">Expense Transaction List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-form"></i><span class="nav-text">HK</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('shop.hk.form')}}">Form</a></li>
                            <li><a href="{{route('shop.hk.list')}}">HK List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-world-2"></i><span class="nav-text">Exchange Entry </span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('shop.bank.depositList')}}">Deposit List</a></li>
                            <li><a href="{{route('shop.bank.withdrawalList')}}">Withdrawal List</a></li>
                            <li><a href="{{route('shop.bank.expenseList')}}">Expense List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-form"></i><span class="nav-text">Reports</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('shop.report.dailyReport')}}">Daily Report</a></li>
                            <li><a href="{{route('shop.report.SearchDate')}}">Monthly Report</a></li>
                        </ul>
                    </li>
            <!-- shop sidenavbar end -->
            <!-- admin sidenavbar start -->
                @elseif(Auth::user()->role === "admin")
                    <li class="nav-label first">Main Menu</li>
                    <li><a href="{{route('admin.dashBoard')}}"><i class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-form"></i><span class="nav-text">Created ID</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('admin.customer.list')}}">User List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-form"></i><span class="nav-text">HK</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('admin.hk.list')}}">HK List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon icon-app-store"></i>
                            <span class="nav-text">User</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('admin.user.form')}}">User Form</a></li>
                            <li><a href="{{route('admin.user.detailList')}}">User Detail List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon icon-app-store"></i>
                            <span class="nav-text">Exchange</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('admin.shop.form')}}">Exchange Form</a></li>
                            <li><a href="{{route('admin.shop.detailList')}}">Exchange Detail List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-world-2"></i><span class="nav-text">Exchange Income</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('admin.bank.revenueList')}}">Entry List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-world-2"></i><span class="nav-text">Bank</span></a>
                        <ul aria-expanded="false">
                        <li><a href="{{route('admin.bank.form')}}">Form</a></li>
                        <li><a href="{{route('admin.bank.list')}}">Bank List</a></li>
                            <li><a href="{{route('admin.bank.expenseList')}}">Expense List</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-form"></i><span class="nav-text">Reports</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('admin.report.shopListDetail')}}">Daily Report</a></li>
                            <li><a href="{{route('admin.report.shopSearchDate')}}">Monthly Report</a></li>
                        </ul>
                    </li>
                @endif
            @endif
            <!-- admin sidenavbar end -->
        </ul>
    </div>
</div>

<!--**********************************
    Sidebar end
***********************************-->
