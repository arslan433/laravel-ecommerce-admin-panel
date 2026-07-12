@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10 bg-gray-50 dark:bg-gray-900 min-h-screen rounded-2xl transition-colors duration-200">
    
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white sm:text-3xl">
                Dashboard Overview
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Welcome back, Admin! Here is what's happening today.</p>
        </div>
        <div class="flex gap-3">
            <button class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-center text-sm font-medium hover:bg-opacity-90 shadow-md">
                <i class="fa-solid fa-download mr-2 text-xs"></i> Export Report
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 md:gap-6">
        
        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Sales</span>
                    <h4 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">$45,231.89</h4>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">
                    <i class="fa-solid fa-chart-line text-lg"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-sm text-green-600 dark:text-green-400">
                <i class="fa-solid fa-arrow-up text-xs"></i>
                <span class="font-semibold">12.5%</span>
                <span class="text-gray-400 dark:text-gray-500 text-xs ml-1">vs last month</span>
            </div>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</span>
                    <h4 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">+3,120</h4>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                    <i class="fa-solid fa-bag-shopping text-lg"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-sm text-green-600 dark:text-green-400">
                <i class="fa-solid fa-arrow-up text-xs"></i>
                <span class="font-semibold">4.3%</span>
                <span class="text-gray-400 dark:text-gray-500 text-xs ml-1">vs last week</span>
            </div>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Products</span>
                    <h4 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">842</h4>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400">
                    <i class="fa-solid fa-boxes-stacked text-lg"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-sm text-red-600 dark:text-red-400">
                <i class="fa-solid fa-arrow-down text-xs"></i>
                <span class="font-semibold">0.8%</span>
                <span class="text-gray-400 dark:text-gray-500 text-xs ml-1">Out of stock (5)</span>
            </div>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Customers</span>
                    <h4 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">14,821</h4>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-sm text-green-600 dark:text-green-400">
                <i class="fa-solid fa-arrow-up text-xs"></i>
                <span class="font-semibold">18.2%</span>
                <span class="text-gray-400 dark:text-gray-500 text-xs ml-1">New users today</span>
            </div>
        </div>

    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800 xl:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sales Analytics</h3>
                <span class="text-xs text-gray-400 dark:text-gray-500">Updated 5m ago</span>
            </div>
            <div class="flex h-64 items-center justify-center rounded-lg border border-dashed border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <p class="text-sm text-gray-400 dark:text-gray-500">[ Sales Line Chart Chart Component Goes Here ]</p>
            </div>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Categories</h3>
            </div>
            <div class="flex h-64 items-center justify-center rounded-lg border border-dashed border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <p class="text-sm text-gray-400 dark:text-gray-500">[ Traffic / Categories Pie Chart ]</p>
            </div>
        </div>
    </div>

    <div class="mt-6 rounded-xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-800">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Orders</h3>
            <a href="#" class="text-sm font-medium text-primary hover:underline">View All Orders</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:bg-gray-700/50 dark:text-gray-400">
                        <th class="px-6 py-3">Order ID</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3">Amount</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700 dark:divide-gray-700 dark:text-gray-300">
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#ORD-9482</td>
                        <td class="px-6 py-4">Zeeshan Ahmed</td>
                        <td class="px-6 py-4">Wireless Headphones Pro</td>
                        <td class="px-6 py-4">$129.00</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">Completed</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#ORD-9481</td>
                        <td class="px-6 py-4">Ayesha Khan</td>
                        <td class="px-6 py-4">Leather Smart Watch</td>
                        <td class="px-6 py-4">$89.50</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Pending</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#ORD-9480</td>
                        <td class="px-6 py-4">Ali Raza</td>
                        <td class="px-6 py-4">Ergonomic Gaming Mouse</td>
                        <td class="px-6 py-4">$45.00</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-400">Cancelled</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection