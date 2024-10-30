// Định nghĩa kiểu dữ liệu cho sản phẩm
export interface Product {
    id: number;                 // ID sản phẩm
    name: string;               // Tên sản phẩm
    price: number;              // Giá sản phẩm
    image: string;              // Đường dẫn ảnh
    description?: string;       // Mô tả sản phẩm (tùy chọn)
}

// Danh sách sản phẩm
export const products: Product[] = [
    {
        id: 1,
        name: "Sản phẩm 1",              // Thêm tên sản phẩm ở đây
        price: 100000,                   // Giá sản phẩm
        image: "img/products/product1.jpg", // Thêm đường dẫn ảnh ở đây
        description: "Mô tả sản phẩm 1", // Mô tả sản phẩm (tùy chọn)
    },
    {
        id: 2,
        name: "Sản phẩm 2",              // Thêm tên sản phẩm ở đây
        price: 200000,                   // Giá sản phẩm
        image: "img/products/product2.jpg", // Thêm đường dẫn ảnh ở đây
        description: "Mô tả sản phẩm 2", // Mô tả sản phẩm (tùy chọn)
    },
    {
        id: 3,
        name: "Sản phẩm 3",              // Thêm tên sản phẩm ở đây
        price: 300000,                   // Giá sản phẩm
        image: "img/products/product3.jpg", // Thêm đường dẫn ảnh ở đây
        description: "Mô tả sản phẩm 3", // Mô tả sản phẩm (tùy chọn)
    },
    // Bạn có thể thêm nhiều sản phẩm khác ở đây
];

// Hàm lấy sản phẩm từ server (nếu cần)
export async function fetchProducts(): Promise<Product[]> {
    const response = await fetch('api/products'); // Đường dẫn đến API của bạn
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    const products: Product[] = await response.json();
    return products;
}

// Xuất danh sách sản phẩm và hàm lấy sản phẩm
// Chỉ cần giữ một lần xuất khẩu cho chúng
// export { products, fetchProducts }; // Dòng này đã bị xóa
