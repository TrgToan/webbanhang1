document.addEventListener('DOMContentLoaded', async () => {
    const productContainer = document.getElementById('product-list');

    // Kiểm tra xem productContainer có tồn tại không
    if (!productContainer) {
        console.error('Không tìm thấy phần tử chứa sản phẩm.');
        return;
    }

    // Hàm lấy sản phẩm từ API hoặc cơ sở dữ liệu
    async function fetchProducts() {
        try {
            const response = await fetch('get_products.php'); // Đảm bảo rằng bạn có endpoint này để lấy dữ liệu sản phẩm
            if (!response.ok) {
                throw new Error(`Lỗi khi lấy sản phẩm: ${response.statusText}`);
            }
            return await response.json();
        } catch (error) {
            console.error('Lỗi khi gọi API lấy sản phẩm:', error);
            alert('Có lỗi xảy ra khi lấy danh sách sản phẩm.');
            return [];
        }
    }

    // Gọi hàm để lấy sản phẩm và hiển thị lên trang
    try {
        const products = await fetchProducts();
        products.forEach(product => {
            const productElement = document.createElement('div');
            productElement.classList.add('product-item');
            productElement.innerHTML = `
                <h2>${product.name}</h2>
                <img src="${product.image}" alt="${product.name}">
                <p>Giá: ${product.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</p>
                <button class="add-to-cart" data-product-id="${product.id}">Thêm vào giỏ</button>
            `;
            productContainer.appendChild(productElement);
        });

        // Thêm sự kiện cho các nút "Thêm vào giỏ"
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', async (event) => {
                const productId = event.target.dataset.productId;
                try {
                    const response = await fetch(`add_to_cart.php?product_id=${productId}`, { method: 'GET' });
                    if (response.ok) {
                        alert('Sản phẩm đã được thêm vào giỏ hàng!');
                    } else {
                        const errorText = await response.text();
                        alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng: ' + errorText);
                    }
                } catch (error) {
                    console.error('Lỗi khi thêm sản phẩm vào giỏ:', error);
                    alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
                }
            });
        });
    } catch (error) {
        console.error('Lỗi khi xử lý sản phẩm:', error);
    }
});
