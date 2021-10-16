<?php

return [
    /**
     * Sao chép các route sang các vùng khác
     * VD: ta có route mặc định là index, các vùng hỗ trợ là ['vi','en','jp']
     * thì ta sẽ có tập hợp 4 route lần lượt là
     * index, vi.index, en.index, jp.index
     * Mặc định sẽ không tạo ra các router này
     */
    'locale_route' => false,

    /**
     * Các vùng hỗ trợ
     */
    'supports' => [
        'en',
        'vi',
    ]
];
