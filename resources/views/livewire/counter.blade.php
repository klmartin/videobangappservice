<div class="container w-full md:w-4/5 xl:w-5/5  mx-auto px-2">

    <!--Title-->
    <div class="sm:flex justify-end sm:items-center mb-8">





        <!-- Right: Actions -->

        <!-- Delete button -->
        <div class="table-items-action hidden">
            <div class="flex items-center">
                <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span class="table-items-count"></span>
                    items selected</div>
                <button
                    class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Delete</button>
            </div>
        </div>

        <!-- Dropdown -->
        <!-- Datepicker built with flatpickr -->

        <div class="relative float-right">

            <input name="date_range"
                class="datepicker form-input pl-9 text-slate-500 hover:text-slate-600 font-medium focus:border-slate-300 w-60"
                placeholder="Select dates" data-class="flatpickr-right" />
            <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                <svg class="w-4 h-4 fill-current text-slate-500 ml-3" viewBox="0 0 16 16">
                    <path
                        d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                </svg>
            </div>

        </div>

        <!-- Add view button -->
        <div class="relative inline-flex ml-2">
            <button type="submit"
                class="btn bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600">
                <span class="sr-only">Filter</span><wbr>
                <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                    <path
                        d="M9 15H7a1 1 0 010-2h2a1 1 0 010 2zM11 11H5a1 1 0 010-2h6a1 1 0 010 2zM13 7H3a1 1 0 010-2h10a1 1 0 010 2zM15 3H1a1 1 0 010-2h14a1 1 0 010 2z" />
                </svg>
            </button>
        </div>

        <div x-data="{ open: false, selected: 0 }" class=" flex float-right">
            <div class="relative">
                <button
                    class="btn justify-between min-w-44 bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600"
                    aria-label="Select date range" aria-haspopup="true" @click.prevent="open = !open"
                    :aria-expanded="open">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 fill-current text-slate-500 shrink-0 mr-2" viewBox="0 0 16 16">
                            <path
                                d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                        </svg>
                        <span x-text="$refs.options.children[selected].children[1].innerHTML"></span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-slate-400" width="11" height="7"
                        viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="z-10 absolute top-full right-0 w-full bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
                    <div class="font-medium text-sm text-slate-600" x-ref="options">
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 0 && 'text-indigo-500'" @click="selected = 0;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 0 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Today</span>
                        </button>
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 1 && 'text-indigo-500'" @click="selected =1 ;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 1 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Yesterday</span>
                        </button>
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 2 && 'text-indigo-500'" @click="selected = 2;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 2 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>This week</span>
                        </button>
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 3 && 'text-indigo-500'" @click="selected = 3;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 3 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>This Moth</span>
                        </button>
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 4 && 'text-indigo-500'" @click="selected = 3;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 4 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Last Month</span>
                        </button>
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 5 && 'text-indigo-500'" @click="selected = 4;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 6 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>This Year</span>
                        </button>
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 6 && 'text-indigo-500'" @click="selected = 5;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 6 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Custom Range</span>
                        </button>

                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 7 && 'text-indigo-500'" @click="selected = 6;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 7 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>All Time</span>
                        </button>
                    </div>
                </div>
            </div>



            <!-- Filter button -->
            <div class="relative inline-flex ml-2">
                <button x-on:click="TriggerTransactionList(selected,0)"
                    class="btn bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600">
                    <span class="sr-only">Filter</span><wbr>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                        <path
                            d="M9 15H7a1 1 0 010-2h2a1 1 0 010 2zM11 11H5a1 1 0 010-2h6a1 1 0 010 2zM13 7H3a1 1 0 010-2h10a1 1 0 010 2zM15 3H1a1 1 0 010-2h14a1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
        </div>




    </div>





    <div>

        <div class="relative mb-8">
            <div class="absolute bottom-0 w-full h-px bg-slate-200" aria-hidden="true"></div>
            <ul
                class="relative text-sm font-medium flex flex-nowrap -mx-4 sm:-mx-6 lg:-mx-8 overflow-x-scroll no-scrollbar">
                <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                    <a class="block pb-3 text-indigo-500 whitespace-nowrap border-b-2 border-indigo-500"
                        href="#one">Account</a>
                </li>
                <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                    <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap"
                        href="#two">Notifications</a>
                </li>
                <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                    <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap"
                        href="#three">Integrations</a>
                </li>
                <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                    <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap"
                        href="#four">Plans</a>
                </li>
                <li class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                    <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap"
                        href="#five">Billing</a>
                </li>
            </ul>

        </div>
        <!-- End -->
    </div>
    <!--Card-->
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">


        <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead>
                <tr>
                    <th data-priority="1">Name</th>
                    <th data-priority="2">Position</th>
                    <th data-priority="3">Office</th>
                    <th data-priority="4">Age</th>
                    <th data-priority="5">Start date</th>
                    <th data-priority="6">Salary</th>
                </tr>
            </thead>
            <tbody>


                <!-- Rest of your data (refer to https://datatables.net/examples/server_side/ for server side processing)-->


            </tbody>

        </table>


    </div>
    <!--/Card-->


</div>



<script>
    $(document).ready(function() {
        let from, to;

        const initilizeDatePIcker = () => {
            flatpickr('.datepicker', {
                mode: 'range',
                static: true,
                monthSelectorType: 'static',
                dateFormat: 'M j, Y',
                defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
                onReady: (selectedDates, dateStr, instance) => {
                    // eslint-disable-next-line no-param-reassign
                    instance.element.value = dateStr.replace('to', '-');
                    const customClass = instance.element.getAttribute('data-class');
                    instance.calendarContainer.classList.add(customClass);
                },
                onChange: (selectedDates, dateStr, instance) => {
                    // eslint-disable-next-line no-param-reassign
                    instance.element.value = dateStr.replace('to', '-');
                },

                onClose: function(selectedDates, dateStr, instance) {
                    var dateStart = instance.formatDate(selectedDates[0], "d-m-Y");
                    var dateEnd = instance.formatDate(selectedDates[1], "d-m-Y");

                    from = dateStart;
                    to = dateEnd;
                }
            });
        }
        initilizeDatePIcker();
        var table = $('#example').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('payments.user.expired.accounts', [2022 - 01 - 01, 2023 - 02 - 01]) }}'
                },

            })
            .columns.adjust()
            .responsive.recalc();
    });
</script>
