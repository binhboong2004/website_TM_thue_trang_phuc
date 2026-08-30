import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.data('siteHeader', () => ({
    activeMegaMenu: null,
    mobileMenuOpen: false,
    searchOpen: false,
    searchQuery: '',
    suggestions: [
        { label: 'Váy dạ hội đen', meta: 'Thuê & mua', url: '/search?q=vay+da+hoi+den' },
        { label: 'Suit nữ thanh lịch', meta: 'Bộ sưu tập', url: '/collections/suit-nu' },
        { label: 'Saint Laurent', meta: 'Thương hiệu', url: '/brands/saint-laurent' },
        { label: 'Trang phục tiệc cưới', meta: 'Theo dịp', url: '/collections/tiec-cuoi' },
    ],
    get filteredSuggestions() {
        const query = this.searchQuery.trim().toLocaleLowerCase('vi-VN');

        if (query === '') {
            return this.suggestions;
        }

        return this.suggestions.filter((suggestion) =>
            `${suggestion.label} ${suggestion.meta}`.toLocaleLowerCase('vi-VN').includes(query),
        );
    },
    toggleMegaMenu(menu) {
        this.activeMegaMenu = this.activeMegaMenu === menu ? null : menu;
        this.searchOpen = false;
    },
    closeMegaMenu() {
        this.activeMegaMenu = null;
    },
    openSearch() {
        this.searchOpen = true;
        this.activeMegaMenu = null;
        this.$nextTick(() => this.$refs.searchInput?.focus());
    },
    closeSearch() {
        this.searchOpen = false;
        this.searchQuery = '';
    },
}));

Alpine.store('cart', {
    rentalItems: [],
    purchaseItems: [],
    hydrate(rentalItems, purchaseItems) {
        this.rentalItems = rentalItems;
        this.purchaseItems = purchaseItems;
    },
    get itemCount() {
        return this.rentalItems.length + this.purchaseItems.reduce((total, item) => total + item.quantity, 0);
    },
    get rentalSubtotal() {
        return this.rentalItems.reduce((total, item) => total + item.rentalTotal, 0);
    },
    get purchaseSubtotal() {
        return this.purchaseItems.reduce((total, item) => total + (item.unitPrice * item.quantity), 0);
    },
    get frozenDeposit() {
        return this.rentalItems.reduce((total, item) => total + item.deposit, 0);
    },
    get payableSubtotal() {
        return this.rentalSubtotal + this.purchaseSubtotal;
    },
    addPurchase(product, size) {
        const existingItem = this.purchaseItems.find(
            (item) => item.productId === product.id && item.size === size,
        );

        if (existingItem) {
            existingItem.quantity += 1;

            return;
        }

        this.purchaseItems.push({
            id: `purchase-${product.id}-${size}`,
            productId: product.id,
            url: product.url,
            image: product.image,
            brand: product.brand,
            name: product.name,
            size,
            unitPrice: product.purchasePrice,
            quantity: 1,
        });
    },
    addRental(product, rentalDetails) {
        const startDate = new Date(`${rentalDetails.startDate}T00:00:00`);
        const endDate = new Date(`${rentalDetails.endDate}T00:00:00`);
        const millisecondsPerDay = 86_400_000;
        const days = Math.max(1, Math.round((endDate - startDate) / millisecondsPerDay) + 1);
        const formatDate = (date) => new Intl.DateTimeFormat('vi-VN').format(date);

        this.rentalItems.push({
            id: `rental-${product.id}-${rentalDetails.size}-${Date.now()}`,
            productId: product.id,
            url: product.url,
            image: product.image,
            brand: product.brand,
            name: product.name,
            size: rentalDetails.size,
            days,
            startDate: formatDate(startDate),
            endDate: formatDate(endDate),
            rentalTotal: product.rentalPrice * days,
            deposit: product.deposit,
        });
    },
    removeRental(index) {
        this.rentalItems.splice(index, 1);
    },
    removePurchase(index) {
        this.purchaseItems.splice(index, 1);
    },
    updateQuantity(index, change) {
        const item = this.purchaseItems[index];

        if (!item) {
            return;
        }

        item.quantity = Math.max(1, item.quantity + change);
    },
    formatCurrency(value) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            maximumFractionDigits: 0,
        }).format(value);
    },
});

Alpine.start();

const revealItems = document.querySelectorAll('[data-reveal]');

if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    revealItems.forEach((item) => observer.observe(item));
} else {
    revealItems.forEach((item) => item.classList.add('is-visible'));
}