@php
    $leftTitle = $data['left_title'] ?? 'Top 10 namen voor mannelijke en vrouwelijke honden';
    $rightTitle = $data['right_title'] ?? 'Top 10 originele namen voor katten';

    $leftDefaults = ['Max', 'Buddy', 'Joep', 'Ollie', 'Guus', 'Luna', 'Bella', 'Pip', 'Nala', 'Lola'];
    $rightDefaults = ['Simba', 'Max', 'Tommy', 'Charlie', 'Mickey', 'Guus', 'Gizmo', 'Tijger', 'Binky', 'Toby'];

    $leftInput = $data['left_items'] ?? [];
    $rightInput = $data['right_items'] ?? [];

    $leftItems = [];
    $rightItems = [];

    for ($i = 0; $i < 10; $i++) {
        $leftItems[$i] = $leftInput[$i]['name'] ?? $leftDefaults[$i];
        $rightItems[$i] = $rightInput[$i]['name'] ?? $rightDefaults[$i];
    }
@endphp

<!-- top 10 -->
<section class="w-full bg-white py-[48px] md:py-[80px]">

    <div class="max-w-container mx-auto px-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-[48px]">

            <!-- COLUMN 1 -->
            <div>
                <h3 class="text-center font-[Fredoka] font-semibold
                           text-[28px] leading-[36px]
                           text-[#111827] mb-[24px]">
                    {!! nl2br(e(str_replace('<br>', "\n", $leftTitle))) !!}
                </h3>

                <div class="border-[12px] border-[#9ED23A] rounded-[40px] bg-white p-[32px]">
                    <ol class="space-y-[14px]">
                        @for($i = 0; $i < 10; $i++)
                            <li class="flex items-center gap-[16px] text-[18px]">
                                <span class="icon-paw">🐾</span> <span>{{ $i + 1 }}. {{ $leftItems[$i] }}</span>
                            </li>
                        @endfor
                    </ol>
                </div>
            </div>

            <!-- COLUMN 2 -->
            <div>
                <h3 class="text-center font-[Fredoka] font-semibold
                           text-[28px] leading-[36px]
                           text-[#111827] mb-[24px]">
                    {!! nl2br(e(str_replace('<br>', "\n", $rightTitle))) !!}
                </h3>

                <div class="border-[12px] border-[#9ED23A] rounded-[40px] bg-white p-[32px]">
                    <ol class="space-y-[14px]">
                        @for($i = 0; $i < 10; $i++)
                            <li class="flex items-center gap-[16px] text-[18px]">
                                <span class="icon-paw">🐾</span> <span>{{ $i + 1 }}. {{ $rightItems[$i] }}</span>
                            </li>
                        @endfor
                    </ol>
                </div>
            </div>

        </div>

    </div>

</section>
