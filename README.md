Trang Web Bán Hàng Thú Cưng

Thành viên nhóm:
- Trưởng nhóm: Lý Tiểu Mẫn
- Thành viên: Nguyễn Lê Thanh Nhàn, Nguyễn Thị Vinh, Châu Kiến Lâm, Nguyễn Thị Nhã, Ngô Hồ Hồng Kha

1. Ngôn ngữ & Công nghệ
- Backend: C#
- Framework: ASP.NET MVC (.NET Framework hoặc .NET Core)
- Frontend: HTML5, CSS3, JavaScript, jQuery
- Database: Microsoft SQL Server
- CI/CD: GitHub Actions
- Container: Docker (tùy chọn)

2. Yêu cầu môi trường
- .NET SDK 6.0 trở lên (hoặc .NET Framework 4.8)
- SQL Server 2019 trở lên
- Git
- Visual Studio hoặc VS Code
- Docker Desktop (nếu muốn chạy bằng Docker)

3. Cài đặt dự án

3.1 Clone repository
git clone https://github.com/eyheyyyy/TrangWebBanHangThuCung.git
cd TrangWebBanHangThuCung

3.2 Cài đặt dependencies
Mở project bằng Visual Studio hoặc VS Code
Nếu dùng .NET Core, chạy:
dotnet restore
Kiểm tra file appsettings.json để thiết lập chuỗi kết nối DB

4. Chạy project local

4.1 Chạy bằng Visual Studio
- Mở file TrangWebBanHangThuCung.sln
- Chọn IIS Express hoặc project WebApp làm startup
- Nhấn F5 hoặc Run
- Mở trình duyệt truy cập http://localhost:5000

4.2 Chạy bằng .NET CLI
dotnet build
dotnet run --project src/TrangWebBanHangThuCung

5. Chạy bằng Docker (tùy chọn)
docker build -t pet-shop-app .
docker run -p 5000:80 pet-shop-app
Truy cập http://localhost:5000 để xem web

6. CI/CD với GitHub Actions
- Workflow có sẵn trong .github/workflows/ci.yml
- Khi push code lên branch main hoặc dev:
  - Test tự động
  - Build project
  - Deploy nếu có thiết lập

7. Cấu trúc project
/src        -> Code nguồn
/.github    -> CI/CD workflows
/Dockerfile -> Docker build
/README.md  -> Hướng dẫn
.gitignore  -> File bỏ qua khi commit

8. Quy trình làm việc nhóm
- Tạo branch riêng cho feature: git checkout -b feature/tinh-nang-moi
- Pull code mới nhất: git pull origin main
- Push branch khi xong: git push origin feature/tinh-nang-moi
- Tạo Pull Request trên GitHub
- Review & Merge vào dev hoặc main

9. Lưu ý
- Kiểm tra .gitignore trước khi push
- Tuân thủ coding convention và naming convention của nhóm
- Test local trước khi push code lên repo
