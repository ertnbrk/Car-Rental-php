-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2023 at 10:26 AM
-- Server version: 8.0.29
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ip-güz-final`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int NOT NULL,
  `names` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `years` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `capacity` varchar(45) DEFAULT NULL,
  `Kapı` varchar(45) DEFAULT NULL,
  `Bagaj` varchar(45) DEFAULT NULL,
  `Vites` varchar(1) DEFAULT NULL,
  `ozellik` varchar(45) DEFAULT NULL,
  `Fiyat` varchar(45) DEFAULT NULL,
  `miktar` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `names`, `years`, `images`, `capacity`, `Kapı`, `Bagaj`, `Vites`, `ozellik`, `Fiyat`, `miktar`) VALUES
(49, 'Volkswagen ', '2018', 'IMG-63ac628fd8b2e0.10740615.jpg', '4', '4', '4', 'A', 'araçbilgikısmı', '120', 11),
(50, 'BMW', '2020', 'IMG-63b33840bbf730.22788193.jpg', '5', '4', '650', 'A', 'X5', '123', 1),
(51, 'Fiat', '2019', 'IMG-63aca955dfe6c2.52776585.jpg', '4', '4', '4', 'A', 'C500', '80', 50),
(54, 'Mercedes', '2018', 'IMG-63b337a7c99545.41257225.jpg', '5', '4', '480', 'A', 'C180 Kompressor', '150', 9),
(55, 'Opel Astra', '2020', 'IMG-63b547e4497d36.87419510.jpg', '5', '4', '350', 'A', 'Opel Astra-e', '100', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int NOT NULL,
  `fullname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `messag` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `fullname`, `email`, `messag`) VALUES
(6, 'Ahmet Hüseyin', 'deneme@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare varius purus, eget porttitor purus consequat vel. Mauris et nunc eget leo ultricies bibendum. Aliquam sem arcu, egestas quis ante quis, maximus pellentesque nisi. Nam posuere molestie odio in volutpat. In vitae vulputate nibh. Morbi magna elit, semper lobortis sodales ut, efficitur id tortor. Suspendisse vitae vulputate velit. Nulla laoreet erat eget aliquam iaculis. Praesent blandit urna nisl, non pharetra leo sagittis vel. Quisque vitae tincidunt ligula. Curabitur sodales varius egestas. Quisque vitae nulla luctus, dapibus eros ut, tempus diam. Duis suscipit lacinia rutrum.\r\n\r\nMaecenas quis nulla massa. Suspendisse in urna sed nulla ullamcorper malesuada. Pellentesque sit amet magna a lectus tristique suscipit. Morbi venenatis bibendum ante, ac tincidunt libero placerat nec. Nunc vulputate est ligula. Nulla aliquet metus vitae elit imperdiet, et finibus nibh ultrices. Proin hendrerit tellus at nulla sodales fringilla. Fusce vestibulum ante quam, non interdum libero facilisis at. Aenean aliquam tortor efficitur viverra lobortis. Duis sed eros a eros dictum pulvinar. Integer pulvinar pretium lacinia.'),
(7, 'Ahmet Aslan', 'deneme@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare varius purus, eget porttitor purus consequat vel. Mauris et nunc eget leo ultricies bibendum. Aliquam sem arcu, egestas quis ante quis, maximus pellentesque nisi. Nam posuere molestie odio in volutpat. In vitae vulputate nibh. Morbi magna elit, semper lobortis sodales ut, efficitur id tortor. Suspendisse vitae vulputate velit. Nulla laoreet erat eget aliquam iaculis. Praesent blandit urna nisl, non pharetra leo sagittis vel. Quisque vitae tincidunt ligula. Curabitur sodales varius egestas. Quisque vitae nulla luctus, dapibus eros ut, tempus diam. Duis suscipit lacinia rutrum.\r\n\r\nMaecenas quis nulla massa. Suspendisse in urna sed nulla ullamcorper malesuada. Pellentesque sit amet magna a lectus tristique suscipit. Morbi venenatis bibendum ante, ac tincidunt libero placerat nec. Nunc vulputate est ligula. Nulla aliquet metus vitae elit imperdiet, et finibus nibh ultrices. Proin hendrerit tellus at nulla sodales fringilla. Fusce vestibulum ante quam, non interdum libero facilisis at. Aenean aliquam tortor efficitur viverra lobortis. Duis sed eros a eros dictum pulvinar. Integer pulvinar pretium lacinia.');

-- --------------------------------------------------------

--
-- Table structure for table `deneme`
--

CREATE TABLE `deneme` (
  `id` int NOT NULL,
  `resim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `deneme`
--

INSERT INTO `deneme` (`id`, `resim`) VALUES
(1, '.jpg'),
(2, 'IMG-63ac22670a0d09.58043637.jpg'),
(3, 'IMG-63ac22f125c805.57048196.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `idoffers` int NOT NULL,
  `Caption` varchar(45) DEFAULT NULL,
  `Description` mediumtext,
  `teklif` float DEFAULT NULL,
  `kosul` int NOT NULL,
  `aktif` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`idoffers`, `Caption`, `Description`, `teklif`, `kosul`, `aktif`) VALUES
(1, '%20 indirim!', 'Üyelerimize özel her 3 siparişe %20 indirim', 0.2, 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_id` varchar(45) NOT NULL,
  `Customer_name` varchar(45) NOT NULL,
  `Customer_num` varchar(45) NOT NULL,
  `delivered_loc` varchar(45) NOT NULL,
  `return_loc` varchar(45) NOT NULL,
  `return_date` date DEFAULT NULL,
  `deliver_date` date DEFAULT NULL,
  `car` int NOT NULL,
  `indirim` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `Customer_name`, `Customer_num`, `delivered_loc`, `return_loc`, `return_date`, `deliver_date`, `car`, `indirim`) VALUES
(71, '21333733333', 'Deneme', '1977777777', 'Balıkesir', 'Antalya', '2023-01-14', '2023-01-02', 54, 20),
(72, '11111111111', 'Alperen', '1478888888', 'Balıkesir', 'Antalya', '2023-01-21', '2023-01-04', 49, 20),
(73, '11111111111', 'Alperen', '1478888888', 'Balıkesir', 'Balıkesir', '2023-01-29', '2023-01-04', 50, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `content` longtext NOT NULL,
  `order` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `summary`, `content`, `order`) VALUES
(1, 'Hakkımızda', 'Özel araçlardan kargo kamyonetlerine kadar geniş bir yelpazede kiralama seçenekleri sunuyoruz.Prestijli kiralık arabalarımızdan biriyle şık bir şekilde gelin. Dünyanın önde gelen üreticilerinden özel, lüks ve sportif kiralık araç yelpazemizi keşfedin.', '<section class=\"section-background\">\n          <div class=\"container\">\n               <div class=\"row\">\n                    <div class=\"col-md-offset-1 col-md-4 col-xs-12 pull-right\">\n                         <img src=\"images/about-1-720x720.jpg\" class=\"img-responsive img-circle\" alt=\"\">\n                    </div>\n\n                    <div class=\"col-md-7 col-xs-12\">\n                         <div class=\"about-info\">\n                              <h2>Ertan Rentacar Oto Kiralama</h2>\n\n                              <figure>\n                                   <figcaption>\n                                        <p>Firmamız; Ertan Rent a car 2020 yılında sektörde yerini almıştır. Ticari politikamız her zaman uygun fiyat, sınırsız hizmet ve dürüstlüğe dayanmaktadır.\nSektörde \"Önce Müşteri Memnuniyeti\" diyerek yola çıkan firmamız, genç araç filosu ve güler yüzlü kadrosuyla siz müşterilerimizin problemsiz, güvenli, rahat ve ekonomik Araç Kiralama hizmeti almanız için çaba göstermektedir. Otomotiv Kiralama\'da eksikliği hissedilen güvenli araç, hizmet kalitesi ve ekonomik fiyat üçlüsünü Ertan Rentacar\'da bulacaksınız.\nFirmamızın Anadolu Yakası, Merkezi Ümraniye, Şube: Beykoz - Kavacık, Ataşehir, Çekmeköy Havalimlarında hizmetinizdedir.</p>\n\n                                        \n                                   </figcaption>\n                              </figure>\n                         </div>\n                    </div>\n               </div>\n          </div>\n     </section>\n\n     <section>\n          <div class=\"container\">\n               <div class=\"row\">\n                    <div class=\"col-md-4 col-xs-12\">\n                         <img src=\"images/about-2-720x720.jpg\" class=\"img-responsive img-circle\" alt=\"\">\n                    </div>\n\n                    <div class=\"col-md-offset-1 col-md-7 col-xs-12\">\n                         <div class=\"about-info\">\n                              <h2>Neden Ertan Rent a car tercih edilmeli ? </h2>\n\n                              <figure>\n                                   <figcaption>\n                                        <p>Bünyesindeki son model lüks araçlar ile ve sunduğu hizmet kalitesiyle İstanbul oto kiralama piyasasına yeni bir anlayış katmıştır. Audi Q7 kiralama, BMW X5 kiralama, Range rover kiralama, Limuzin kiralama, kiralık oto denildiğinde istanbul oto kiralama sektöründe akla gelen ilk isim Ertan Rentacar araç kiralama hizmetidir. Ertan Rent A Car Oto kiralama filosundaki tamamı son model lüks ve orta segment araçlarıyla da ucuz araba kiralama kavramına fiyat kalite kavramını da eklemiştir. En iyi fiyatlarla, en yüksek kaliteyi bir anda sunan Ertan Rent A Car, müşterilere sunduğu 24 saat yol yardımıyla her zaman yanınızdadır. Ertan Rentacar güvencesini ve konforunu sizde yaşayın. Sitemizde görmüş oldugunuz araç resimleri araçlarımızın firma önünde çekilmiş orjinal resimleridir.</p>\n\n                                        <p>Sizde sınıfının öncüsü lüks araçlarla BMW X5 kiralama, Audi Q7 kiralama, Jeep kiralama, Oto kiralama, Kiralık oto, Kiralık Araç hizmeti istediğinizde Ertan Rent A Car en profesyonel çözüm ortağınız. Firmanızın Araç kiralama yöntemiyle artık VIP Aracı Var! Kurumsal platformda, şirketinizin prestijini arttırmak için lüks araç kiralama avantajlarını yaşayın. Müşterileriniz yada şirket bağlantılarınız daha size gelmeden etkilensin. Markasının prestijini minle paylaşan, konforuyla ve güç gösterisiyle hayranlık kazandıran markalar Kiralık Audi, Kiralık Bmw, Kiralık Mercedes, Kiralık Porsche, Kiralık Chrysler, Kiralık Cadillac, Kiralık Dodge, Kiralık Honda, Kiralık Land Rover, Kiralık Range Rover, size birçok kapıları açacak olan anahtarınız olacak.</p>\n                                   </figcaption>\n                              </figure>\n                         </div>\n                    </div>\n               </div>\n          </div>\n     </section>\n\n     <section class=\"section-background\">\n          <div class=\"container\">\n               <div class=\"row\">\n                    <div class=\"col-md-12 col-sm-12\">\n                         <div class=\"text-center\">\n                              <h2>Kişisel Oto Kiralama</h2>\n\n                              <br>\n\n                              <p class=\"lead\">Ertan Rentacar Filosundaki gerek VİP Araç kiralama gerekse Lüks ve Orta segment araç kiralama ile farklı isteklere farklı çözümler üretiyor.Kişisel olarak tercihleriniz dahilinde önceden planladığınız özel günleriniz için Ertan Oto kiralama çözüm ortağınız. Deneyimli kadrosuyla size muhteşem bir yolculuk deneyimi yaşatacak tatil ve özel günleriniz için özel çözümler sunuyor. Ertan Rent A Car size sorunsuz bir yolculuk deneyimi sağlamak için çözüm ortağınız hemen bize ulaşın ve isteklerinizi belirtmekten çekinmeyin.\nHem Avrupa yakasında hem de Anadolu yakasında Havalimanlarında Sizi bekleyen Şöförlü Vip araçlar ile sorunsuz kaliteli, zamanında, konforlu ve prestijli bir yolculuğun keyfini çıkarın. Audi Q7 kiralama, BMW X5 Kiralama, Range Rover Kiralama, Kiralık oto, Jeep Kiralama, Lüks Araç Kiralama en fazla tercih edilen seçeneklerdir.</p>\n                         </div>\n                    </div>\n               </div>\n          </div>\n     </section>', 1),
(2, 'Ekibimiz', 'Ekibe dahil olabilmek için bizimle iletişme geçiniz', 'ekip', 2),
(3, 'Görüşler', 'Alanlarında uzman kullanıcılarımızın görüşleri', 'görüş', 3),
(4, 'Sözleşme', 'Hizmetlerimizden yararlanmanız durumunda aşağıdaki sözleşmeyi kabul etmiş bulunacaksınız', '<section class=\"section-background\">\r\n          <div class=\"container\">\r\n               <div class=\"about-info\">\r\n                    <h2>Araç Kiralama Sözleşmesi</h2>\r\n\r\n                    <figure>\r\n                         <figcaption>\r\n                              <h3>Sözleşme</h3>\r\n                              <p>Lİşbu \"Araç Kira Sözleşmesi\" (Kısaca \"Sözleşme\") taraflar arasında imzalanan ARAÇ TESLİM FORMU\'nun (Kısaca \"Form\") eki ve ayrılmaz bir parçasıdır. İşbu sözleşme ile Mizraklı Oto Kiralama Bilişim Peyzaj Temizlik Ticaret Ltd Şti (Kısaca \"Kiraya Veren\") maliki ya da işletme sahibi bulunduğu Form\'da belirtilen aracı, belirlenen tarihlerde, Form\'da adı ve adresi bulunan Kiracı\'ya kiralamıştır. Kiracı işbu sözleşme konusu aracı koşullara uygun olarak kullanmayı (kiralama süresi, iade saati, dönüş istasyonu vb.), kira ücretini tam ve zamanında ödemeyi beyan ve taahhüt eder. İşbu sözleşmeyi imzalamakla, Kiracı kiralanan ile ilgili tüm yükümlülükleri üstlenmiş olur. Kiracı, gerek aracı teslim alması, gerekse iade etmesi sırasında düzenlenecek Araç Teslim Formlarını imzadan imtina etmeyeceğini, Formları imzalamaması halinde formda yazılanları koşulsuz olarak kabul etmiş sayılacağını, form içeriğine herhangi bir itirazı olması halinde imzadan imtina yoluyla değil, ancak masrafı kendisine ait olmak kaydıyla bir uzmana ekspertiz yaptırmak kanalıyla itiraz ve iddialarını ileri sürebileceğini peşinen kabul, beyan ve taahhüt eder.\r\n   \r\n    \r\n    </p>\r\n                         </figcaption>\r\n                    </figure>\r\n\r\n                    <figure>\r\n                         <figcaption>\r\n                              <h3>Araç Teslim Alımı ve Geri Teslimi</h3>\r\n                              \r\n\r\n                              <p> Kiracının sözleşme ve eklerinde beyan ettiği adres, yasal tebligat adresi olup, Kiraya Verene yazılı olarak adres değişikliği bildirilmedikçe bu adrese yapılacak tüm bildirimler Tebligat Kanunu hükümlerine göre tebliğ edilmiş ve geçerli sayılacaktır.\r\n    Kiracının işbu sözleşmeyi imzalaması ile söz konusu aracı hem mekanik hem de kaporta açısından sağlam faal vaziyette ve iyi durumda teslim aldığını, aracın Form\'da belirtildiği gibi teslim edildiğinin esas olduğunu, araçta teslim sırasında var olan her türlü ayıbın Form\'da belirtileceğini, aksi halde aracın Kiraya Verene iadesi sırasında tespit olunan her türlü ayıba Kiracı\'nın sebep olmuş kabul edileceği hususunda taraflar mutabıktır. Kiracı, aracın teslimi sırasında Form\'da tanımlanalar haricinde hiçbir hasar ve kaza izi bulunmadığını kabul eder.\r\n    Kiracı aracı, araca ait tüm belgeler, aksesuar avadanlıkları, yedek lastiği ile birlikte teslim aldığı gibi araç kiraladığı istasyona veya sözleşmede belirtilen başka bir yerdeki Kiraya Veren ofisine iade edecektir. Kiracı, kiralanan aracın kullanımı sürecinde talep edeceği bebek koltuğu, navigasyon cihazı vb. ilave hizmet ve donanımların Kiraya Veren tarafından bildirilecek ek kira bedelini de işbu sözleşme hükümlerine uygun olarak ödemek zorundadır.\r\n    Kiracının sağlam ve iyi durumda teslim almış olduğu araçta kullanım hatası ve/veya dikkatsizlik tedbirsizlik nedeni oluşan, trafik sigorta kuralları kapsamında sigortadan talep ve tahsil edilemeyen gerek Kiraya Veren gerekse üçüncü kişiler nezdinde doğan her türlü doğrudan ve dolaylı zarar, ziyan, hasar ve cezalardan münhasıran Kiracı sorumludur.</p>\r\n                         </figcaption>\r\n                    </figure>\r\n\r\n                    <figure>\r\n                         <figcaption>\r\n                              <h3>Kiralama Şartları</h3>\r\n                              \r\n\r\n                              <p>Kiracının Ekonomi grup araçlarda en az 21 yaşında ve 2 yıllık ehliyet, orta grup araçlarda 24 yaş ve 3 yıllık ehliyet, üst grup araçlarda 27 yaş ve 4 yıllık ehliyet sahibi olması gerekmektedir. Kiracı dışında aracı kullanacakların da genel kiralama koşullarına uygun süreleri doldurmuş olması, ek sürücü olarak Kiraya Veren\'e önceden yazılı olarak bildirilmesi ve/veya sözleşme üzerine bilgilerinin kayıt edilmesi ile mümkündür. Aksi halde gerek Kiraya Veren gerekse üçüncü kişiler nezdinde doğabilecek her türlü doğrudan ve dolaylı zarardan münhasıran Kiracı sorumludur.\r\n    Kiralama süresi minimum 24 saattir. Bu süreden daha kısa kiralamalarda kira ücreti 1(bir) gün olarak hesaplanacaktır. Kiracı, geçerli fiyat tarifesindeki günlük kira ücretinin kira gün sayısı üzerinden hesaplanan kira bedelini peşin olarak nakden ve defaten ödemekle yükümlüdür.</p>\r\n                         </figcaption>\r\n                    </figure>\r\n\r\n\r\n                    <figure>\r\n                         <figcaption>\r\n                              <h3>Ücretlendirme</h3>\r\n                              \r\n\r\n                              <p>Kiracı kira ücretinin dışında ayrıca;\r\n\r\n2 saati aşan gecikmelerde, 1 günlük kira bedelini,\r\nKiralama sonunda ortaya çıkabilecek tek yön ücretini,\r\nYakıt, otoyol geçiş ücretleri, her türlü park ve ulaşım masrafları ile kiralananın kullanılmasına yönelik her türlü yan gider, masraf ve kiralananın Kiracıya teslimi sonrasında doğacak tüm masraflar münhasıran Kiracıya ait olduğundan bu kapsamdaki tüm bedelleri ödemekle mükelleftir.\r\n    Kiracı ödemeleri kiralama süresinin başlangıcında kredi kartı, nakit veya voucher ile yapacaktır. Kiracı kira bedelinin ve sözleşme kapsamındaki diğer bedellerin ve yasal ödemelerin ödenmemesi durumunda hiçbir ihbar ve ihtara gerek kalmaksızın fatura tarihinden itibaren bedellerin muaccel olacağını ve fatura tarihinden itibaren aylık %5 (yüzde beş) temerrüt faizi ödemeyi kabul beyan ve taahhüt eder.</p>\r\n                         </figcaption>\r\n                    </figure>\r\n\r\n                    \r\n               </div>\r\n          </div>\r\n     </section>', 0),
(5, 'İletişim', 'Şikayet,öneri,memnuniyet,danışma ve Takıma katılmak için bizimle iletişime geç\n               ', '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `idslider` int NOT NULL,
  `resim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`idslider`, `resim`) VALUES
(4, 'IMG-63af6eef660885.66729789.jpg'),
(6, 'IMG-63af713ceac286.57016588.jpg'),
(9, 'IMG-63b09b31e59fe6.36510240.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int NOT NULL,
  `isim` varchar(45) DEFAULT NULL,
  `soyisim` varchar(45) DEFAULT NULL,
  `Pozisyon` varchar(45) DEFAULT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `isim`, `soyisim`, `Pozisyon`, `images`) VALUES
(2, 'Asaf', 'Aydemir', 'CTO', 'IMG-63af2f62d7f139.79942592.jpg'),
(17, 'ERTAN', 'FELEK', 'FOUNDER', 'IMG-63b5414d91a9b2.26533353.jpg'),
(18, 'FURKAN', 'KACMAZ', 'CEO', 'IMG-63b5415cd70a06.58114346.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `counts` int NOT NULL,
  `names` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `images` varchar(255) NOT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `star` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`counts`, `names`, `title`, `images`, `comment`, `star`) VALUES
(12, 'Ahmet', 'Shopify Developer', 'IMG-63b545e6259521.88233418.jpg', 'HARİKA MUAZZAM FALAN FILAN', '3'),
(13, 'Kemal', 'Web Designer', 'IMG-63b54616aa5b43.22447852.jpg', 'Harika masallah inşallah falan filan', '4'),
(14, 'Mahmut', 'Shopify Developer', 'IMG-63b546760e1c42.57567895.jpg', 'asffwqrqwqwqttqwwqt\r\nasfwqwqtwqqwtwqtwq', '4');

-- --------------------------------------------------------

--
-- Table structure for table `üye`
--

CREATE TABLE `üye` (
  `üyeTc` varchar(45) NOT NULL,
  `üyeAd` varchar(45) DEFAULT NULL,
  `üyeSoyad` varchar(45) DEFAULT NULL,
  `üyeTelefon` varchar(45) DEFAULT NULL,
  `üyeAdres` varchar(150) DEFAULT NULL,
  `üyeMail` varchar(45) DEFAULT NULL,
  `üyeSifre` varchar(45) NOT NULL,
  `admin` varchar(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `üye`
--

INSERT INTO `üye` (`üyeTc`, `üyeAd`, `üyeSoyad`, `üyeTelefon`, `üyeAdres`, `üyeMail`, `üyeSifre`, `admin`) VALUES
('11111111111', 'Alperen', 'Aygün', '1478888888', 'Adresim', 'ertan.felek44@xn--gmas-75a.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0'),
('12312222222', 'Yusuf Raşit', 'Tanrıkulu', '4555555555', 'KArtal', 'yusuf.tanrikulu@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0'),
('15233333333', 'Ertan burak ', 'FELEK', '7779999922', 'Malatya Akçadağ Ilıcak', 'ertan00@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '1'),
('17306535662', 'Furkan', 'Kaçmaz', '2312142142', 'istanbul', 'furkan-kacmaz@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deneme`
--
ALTER TABLE `deneme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`idoffers`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`idslider`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`counts`);

--
-- Indexes for table `üye`
--
ALTER TABLE `üye`
  ADD PRIMARY KEY (`üyeTc`),
  ADD UNIQUE KEY `üyeTc_UNIQUE` (`üyeTc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `deneme`
--
ALTER TABLE `deneme`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `idoffers` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `idslider` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `counts` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
