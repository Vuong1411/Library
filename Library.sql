-- THỂ LOẠI SÁCH --
CREATE TABLE category (
    category_id INT PRIMARY KEY AUTO_INCREMENT, -- Mã số thể loại.
    category_name NVARCHAR(100) NOT NULL -- Tên thể loại sách.
);

-- NHÀ XUẤT BẢN --
CREATE TABLE publisher (
    publisher_id INT PRIMARY KEY AUTO_INCREMENT, -- Mã số nhà xuất bản.
    publisher_name NVARCHAR(100), -- Tên nhà xuất bản.
    publication_language NVARCHAR(50), -- Ngôn ngữ xuất bản.
    publication_type NVARCHAR(50) -- Loại hình xuất bản (ví dụ: sách bìa cứng, sách bìa mềm, ebook).
);

-- VỊ TRÍ SÁCH TRONG THƯ VIỆN --
CREATE TABLE location (
    location_id INT PRIMARY KEY AUTO_INCREMENT, -- Mã số vị trí.
    shelf_no VARCHAR(50), -- Số kệ sách.
    shelf_name NVARCHAR(100), -- Tên kệ sách.
    floor_no INT -- Số tầng chứa sách.
);

-- THÔNG TIN TÁC GIẢ --
CREATE TABLE author (
    author_id INT PRIMARY KEY AUTO_INCREMENT, -- Mã số tác giả.
    first_name NVARCHAR(50), -- Tên của tác giả.
    last_name NVARCHAR(50) -- Họ của tác giả.
);

-- THÀNH VIÊN THƯ VIỆN --
CREATE TABLE member (
    member_id INT PRIMARY KEY AUTO_INCREMENT, -- Mã số thành viên.
    first_name NVARCHAR(50), -- Tên của thành viên.
    last_name NVARCHAR(50), -- Họ và tên của thành viên.
    phone VARCHAR(11), -- Số điện thoại của thành viên.
    email VARCHAR(100), -- Địa chỉ email của thành viên.
    date_of_birth DATE, -- Ngày sinh của thành viên.
    registration_date DATE, -- Ngày đăng ký thẻ thành viên.
    is_active BOOLEAN -- Trạng thái hoạt động của thành viên.
);

-- THÔNG TIN VỀ SÁCH --
CREATE TABLE book (
    book_id INT PRIMARY KEY AUTO_INCREMENT, -- Mã số sách.
    ISBN VARCHAR(20), -- Mã số sách quốc tế.
    book_title NVARCHAR(255), -- Tiêu đề sách.
    category_id INT, -- Thể loại sách.
    publisher_id INT, -- Nhà xuất bản.
    publication_year YEAR, -- Năm xuất bản.
    copies_total INT, -- Tổng số bản sách.
    copies_available INT, -- Số bản sách còn trống.
    location_id INT, -- Vị trí của sách trong thư viện.
    keywords TEXT, -- Các từ khóa liên quan đến sách.
    FOREIGN KEY (category_id) REFERENCES category(category_id),
    FOREIGN KEY (publisher_id) REFERENCES publisher(publisher_id),
    FOREIGN KEY (location_id) REFERENCES location(location_id)
);

-- TÁC GIẢ CỦA SÁCH --
CREATE TABLE author_book (
    author_id INT, -- Mã số tác giả.
    book_id INT, -- Mã số sách.
    PRIMARY KEY (author_id, book_id),
    FOREIGN KEY (author_id) REFERENCES author(author_id),
    FOREIGN KEY (book_id) REFERENCES book(book_id)
);

-- ĐÁNH GIÁ SÁCH --
CREATE TABLE book_rating (
    rating_id INT PRIMARY KEY AUTO_INCREMENT, -- Mã số đánh giá.
    book_id INT, -- Sách được đánh giá. 
    member_id INT, -- Thành viên đánh giá.
    rating INT, -- Điểm đánh giá (từ 1 đến 5).
    comment TEXT, -- Nhận xét về sách.
    FOREIGN KEY (book_id) REFERENCES book(book_id),
    FOREIGN KEY (member_id) REFERENCES member(member_id)
);

-- TRẠNG THÁI CỦA VIỆC MƯỢN SÁCH --
CREATE TABLE issue_status (
    status_id INT PRIMARY KEY, -- Mã số trạng thái.
    status_name NVARCHAR(50) -- Tên trạng thái.
);

-- MƯỢN SÁCH --
CREATE TABLE book_issue (
    issue_id INT PRIMARY KEY AUTO_INCREMENT, -- Mã số mượn sách.
    book_id INT, -- Sách được mượn.
    member_id INT, -- Thành viên mượn sách.
    issue_date DATE, -- Ngày mượn sách.
    due_date DATE, -- Ngày trả sách dự kiến.
    return_date DATE, -- Ngày trả sách thực tế.
    status_id INT, -- Trạng thái của việc mượn sách.
    FOREIGN KEY (book_id) REFERENCES book(book_id),
    FOREIGN KEY (member_id) REFERENCES member(member_id),
    FOREIGN KEY (status_id) REFERENCES issue_status(status_id)
);

-- PHẠT VI PHẠM --
CREATE TABLE fine (
    fine_id INT PRIMARY KEY AUTO_INCREMENT,
    member_id INT, -- Thành viên bị phạt.
    book_id INT, -- Sách bị phạt.
    fine_amount DECIMAL(10,2), -- Số tiền phạt.
    fine_reason NVARCHAR(255), -- Lý do phạt.
    fine_date DATE, -- Ngày phạt.
    payment_date DATE, -- Ngày thanh toán phạt.
    payment_method NVARCHAR(50), -- Phương thức thanh toán phạt.
    FOREIGN KEY (member_id) REFERENCES member(member_id),
    FOREIGN KEY (book_id) REFERENCES book(book_id)
);