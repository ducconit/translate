<?php

return [
    /**
     * Sao chép các route sang các vùng khác
     * VD: ta có route mặc định là index, các vùng hỗ trợ là ['vi','en','jp']
     * thì ta sẽ có tập hợp 4 route lần lượt là
     * index, vi.index, en.index, jp.index
     * Mặc định sẽ không tạo ra các router này
     */
    'route-name-locale' => false,

    /**
     * Route thay đổi vùng mặc định
     *
     * Uri: change-locale/{locale?}
     * Name: changeLocale
     */
    'use-route-change-locale' => true,

    /**
     * Tự động chuyển vùng khi phát hiện vùng trên url hoặc trong session
     *
     * ex: domain/vi/dashboard     =>   locale: vi
     *
     * ex2: domain/en/dashboard    =>   locale: en
     *
     * ex3: domain/dashboard       =>   locale: default(en)
     */
    'use-locale-middleware' => true,

    /**
     * Các vùng hỗ trợ
     */
    'supports' => [
        'en',
        'vi'
    ],

    /**
     * Danh sách middleware đi kèm
     */
    'middleware' => []
];
