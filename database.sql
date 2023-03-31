drop database if exists ROSIESTORE 
create database ROSIESTORE 
go
use ROSIESTORE 
create table  BRAND(
  IDBR varchar(5) primary key,
  NAMEBR varCHAR(25) not null,
  STTBRAND tinyint
)
go

create table  CATEGORY(
IDCTGR varchar(5) primary key ,
NAMECTGR varCHAR(40) not null,
STTCT tinyint
)
go
create table PRODUCT(
IDPR INT PRIMARY KEY identity,
NAMEPR varchar(100) not null,
IDCTGR varchar(5),
IDBR varchar(5) not null ,
PRICE decimal(7,0),
QUANTITY int,
BRIEFSUM varchar (200),
DESCRIPTION varchar(1200),
CREATEDATE date,
STATUSPRO tinyint,
FOREIGN KEY (IDBR) references brand(IDBR),
FOREIGN KEY (IDCTGR) references category(IDCTGR)
)
go

create table  IMAGES(
   IDIM int primary key identity,
   NAMEIM varchar(40) not null ,
   COLOR varchar(20),
   DETAILQUANTITY int,
   IDPR INT,
   STTIM tinyint
)

go
alter table IMAGES
add constraint FK_IMAGE
foreign key (IDPR)
references PRODUCT(IDPR)
go
create or alter trigger update_quantity_PRODUCT_from_IMAGE
ON IMAGES
for INSERT, update
AS
begin
	declare @IDPR varchar(10)
	set @IDPR= ( select IDPR from inserted)
	declare @total int
	set @total = (select sum(DETAILQUANTITY) from IMAGES where IDPR=@IDPR)
	update PRODUCT set QUANTITY=@total where IDPR=@IDPR
end
go
create table USERS(
 USERNAME varchar(25) primary key,
 PASS varchar(30) not null ,
 EMAIL varchar(50) not null ,
 PHONE varchar(50) not null ,
 locktime datetime,
 STTUSER tinyint
)
go
create table verified_action(
 USERNAME varchar(25) primary key,
 NEWINFO varchar(50),
 verification_code varchar(50),
 verified_time datetime
)
go
create or alter trigger insert_verified_action
ON verified_action 
for INSERT 
AS
begin
	declare @nowtime datetime
	set @nowtime= GETDATE()
	declare @USERNAME varchar(25)
	set @USERNAME= ( select USERNAME from inserted)	
	update verified_action set verified_time= @nowtime where USERNAME=@USERNAME				
end
go
create or alter proc del_verified_time
as
begin
	delete verified_action
		WHERE (SELECT DATEDIFF(MINUTE,verified_time,getdate()) 
				from verified_action 
				where verified_time is not null or verified_time != '')>=5		
end
go





create table ORDERS
(
    IDIV INT PRIMARY KEY identity,
	USERNAME varchar(25) not null,
	SUBPAID decimal(10,0),
	FULLNAME Nvarchar(50),
	PHONE varchar(50),
	ADDDRESS Nvarchar(100),
	NOTE Nvarchar(500),
	CREATETIME datetime,
	STTO tinyint,
	CFBY varchar(25),
    FOREIGN KEY (USERNAME) references USERS(USERNAME)
)
go
create table details_ORDERS
(
    IDIV int,
	IDPR INT  not null,
	QUANTITY_order int,
	PRICE decimal(7,0),
    FOREIGN KEY (IDPR) references PRODUCT(IDPR),
	FOREIGN KEY (IDIV) references ORDERS(IDIV)
)
go
create or alter trigger update_IDIV_ORDERS
ON ORDERS
for insert
	as
	begin
		declare @nowtime datetime
		set @nowtime= GETDATE()
		Declare @IDIV varchar(10)
		Declare @USERNAME varchar(25)
		Set @IDIV=(select IDIV from inserted) 
		Set @USERNAME=(select USERNAME from inserted)	
			UPDATE ORDERS set CREATETIME=@nowtime where USERNAME=@USERNAME			
	end
	go



create or alter trigger update_SUBPAID_ORDERS
ON details_ORDERS
for INSERT, update
AS
begin
	declare @IDIV varchar(10)
	set @IDIV= ( select IDIV from inserted)
	declare @total int
	set @total = (select sum(PRICE) from details_ORDERS where IDIV=@IDIV)
	update ORDERS set SUBPAID=@total where IDIV=@IDIV
end
go
create table LOCKUSERS
(
    USERNAME varchar(25) not null,
    TIMELOGFAILS DATETIME ,
    COUNTS tinyint
)
go
insert into USERS(USERNAME, PASS,  EMAIL, PHONE)
values ('admin','$1Sapgayroi','roisiestore.hcm@gmail.com','+84904859325')
GO
insert into USERS(USERNAME, PASS, EMAIL, PHONE)
values ('khongmaplam','$1Sapgayroi','dongthithanhxuan.hn@gmail.com','0904859325')
GO
insert into USERS(USERNAME, PASS,  EMAIL, PHONE,locktime)
values ('test','$1Sapgayroi','nguyenlan3105@gmail.com','09090909090','2021-04-21 12:02:21')
GO

create or alter trigger insert_LOCKUSERS
ON LOCKUSERS 
for INSERT 
AS
begin
	declare @nowtime datetime
	set @nowtime= GETDATE()
	
	declare @USERNAME varchar(25)
	set @USERNAME= ( select USERNAME from inserted)

	declare @temcounts tinyint
	declare @counts tinyint
	set @temcounts = (select max(COUNTS) FROM LOCKUSERS WHERE USERNAME= @USERNAME)
	if (@temcounts is null)
		begin
				update LOCKUSERS set TIMELOGFAILS= @nowtime, COUNTS=1 where USERNAME=@USERNAME
		end
	else
		set @counts=@temcounts +1
		begin
			if(@counts<=5)
				begin
					update LOCKUSERS set TIMELOGFAILS= @nowtime, COUNTS=@counts where( USERNAME=@USERNAME and COUNTS IS NULL)
				end
			if (@counts=5)
				begin
					update USERS set locktime=@nowtime where USERNAME=@USERNAME
					delete LOCKUSERS where USERNAME=@USERNAME
				end
		end
end
go
create or alter trigger insert_BRAND
ON BRAND
After insert
	as
	begin
		Declare @IDBR varchar(5)
		Declare @count INT
		Declare @NAMEBR varchar(25)
		Set @IDBR=(select IDENT_CURRENT('BRAND'))
		Set @NAMEBR=(select NAMEBR from inserted)	
		SET  @count= ( select count(IDBR) from BRAND)
		IF (@count=0)
			begin
			Set @IDBR='BR1'
			UPDATE BRAND set IDBR=@IDBR where NAMEBR=@NAMEBR
			end
		IF (@count>0)
			begin
			Set @IDBR=CONCAT('BR',CONVERT(varchar,@count))
			UPDATE BRAND set IDBR=@IDBR where NAMEBR=@NAMEBR
			end
	end
	go
insert into BRAND(IDBR,NAMEBR) values ('','MAC')
GO
insert into BRAND(IDBR,NAMEBR) values ('','MAYBELLINE')
go
insert into BRAND(IDBR,NAMEBR) values ('','ESTEELAUDER')
go
insert into BRAND(IDBR,NAMEBR) values ('R','CLINIQUE')
go
insert into BRAND(IDBR,NAMEBR) values ('','SHISEIDO')
GO
create or alter trigger insert_CATEGORY
ON CATEGORY
After insert
	as
	begin
		Declare @IDCTGR varchar(5)
		Declare @count INT
		Declare @NAMECTGR varchar(25)
		Set @IDCTGR=(select IDENT_CURRENT('CATEGORY'))
		Set @NAMECTGR=(select NAMECTGR from inserted)	
		SET @count= (select count(IDCTGR) from CATEGORY)
		IF (@count=0)
			begin
			Set @IDCTGR='CT1'
			UPDATE CATEGORY set IDCTGR=@IDCTGR where NAMECTGR=@NAMECTGR
			end
		IF (@count>0)
			begin
			Set @IDCTGR=CONCAT('CT',CONVERT(varchar,@count))
			UPDATE CATEGORY set IDCTGR=@IDCTGR where NAMECTGR=@NAMECTGR
			end
	end
go
insert into CATEGORY(IDCTGR,NAMECTGR) values ('','LIPS')
GO
insert into CATEGORY(IDCTGR,NAMECTGR) values ('','EYES')
GO
insert into CATEGORY(IDCTGR,NAMECTGR) values ('','FACE')
go
insert into CATEGORY(IDCTGR,NAMECTGR) values ('','MASK')
go
insert into CATEGORY(IDCTGR,NAMECTGR) values ('','MOISTURISER')
go
insert into CATEGORY(IDCTGR,NAMECTGR) values ('','SERUM')
go
insert into CATEGORY(IDCTGR,NAMECTGR) values ('','FACE CLEANSERS')
go
insert into CATEGORY(IDCTGR,NAMECTGR) values ('','SUNCREEN SPF')
go
insert into CATEGORY(IDCTGR,NAMECTGR) values ('','ACCESSORIES')
GO
create or alter trigger insert_PRO
ON PRODUCT
After insert
	as
	begin
		Declare @IDPR int
		Declare @count INT

		Declare @CREATEDATE date
		Set @CREATEDATE=(select CREATEDATE from inserted) 
		if(@CREATEDATE is null or @CREATEDATE= '')
		begin
		set @CREATEDATE=GETDATE()
		end
		else
		begin
		set @CREATEDATE=CONVERT(datetime,@CREATEDATE)
		end
		Set @IDPR=(select IDPR from inserted)
	
		SET  @count= ( select count(IDPR) from PRODUCT)
		IF (@count=0)
			begin
			
			UPDATE PRODUCT set CREATEDATE=@CREATEDATE where (IDPR=@IDPR )
			end
		IF (@count>0)
			begin
			
			UPDATE PRODUCT set CREATEDATE=@CREATEDATE where (IDPR=@IDPR )
			end
	end
	go

	
create or alter proc del_locktime
as
begin
	update USERS set locktime = null
		WHERE (SELECT DATEDIFF(MINUTE,locktime,getdate()) 
				from USERS 
				where locktime is not null or locktime != '')>= 15
	delete LOCKUSERS 
		where USERNAME = (SELECT T.USERNAME
					from (SELECT DATEDIFF(MINUTE,TIMELOGFAILS,getdate()) AS Diff,USERNAME,MAX(COUNTS) as C
								from LOCKUSERS 
								where TIMELOGFAILS is not null
								group by USERNAME,TIMELOGFAILS) T
								where T.Diff >=15	)		
	
end
go
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values('FROST LIPSTICK', 'CT1','BR1',440000, 'HIGH PEARL, MEDIUM BUILDABLE COVERAGE, SEMI-LUSTROUS FINISH','M·A·C Lipstick – the iconic product that made M·A·C famous. 
This formula features smooth, medium buildable coverage, high pearl and a semi-lustrous finish.', '2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lipmaccostachic.jpg','#dc7b7d',40,1)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR)  
values ('lipmacCB96.jpg','#cc5a3b',20,1)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lipmacangel.jpg','#d9a1a7',40,1)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR)  
values ('lipmacnyapple.jpg','#903a59',70,1)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'PRO LONGWEAR PAINT POT', 'CT2','BR1',530000,'EYE PRIMER/CREAM SHADOW, 24-HOUR WEAR, HIGHLY PIGMENTED' ,
'A highly pigmented, long-wearing, blendable eye primer and/or cream shadow – M·A·C Pro Longwear Paint Pot goes on creamy and dries 
to an intense, vibrant finish that lasts for 24 hours. The innovative second skin-like creamy shadow formula blends smoothly over 
lids and creates seamless, buildable coverage without looking heavy or cakey. Its superior colour purity stays true and will not 
streak or crease. Pro Longwear Paint Pot can be mixed with other products, like M·A·C shadows and liners.', '2021-01-01')
go

insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('eye-mac-paint-pot-painterly.jpg', '#e4b09a', 15,2)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('eye-mac-babe-in-charm.jpg', '#bd3f3f', 20,2)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('eye-mac-contemplative.jpg', '#d0935a', 30,2)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'STUDIO FIX FLUID SPF 15', 'CT3','BR1',760000,'24-HOUR MEDIUM-TO-FULL COVERAGE, MATTE FINISH, CONTROLS OIL/SHINE',
'We put M∙A∙C Studio Fix Fluid SPF 15 to the ultimate test of seeing how long it wears and, not surprisingly, the formula lasts for 
a full 24 hours! This modern matte, liquid foundation combines medium-to-full buildable coverage with broad spectrum SPF 15 
protection. Applies, builds and blends easily and evenly while controlling shine with a non-caking, breathable formula that does not
cause acne. Comfortable and extremely long-wearing, it helps minimize the appearance of pores, giving skin a smoother and more even 
look and finish. Available in our most inclusive range of colours. Ideal for all skin types – especially oily skin.', '2021-01-01')
go
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('face-mac-nc42.jpg', '#d59767', 24,3)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('face-mac-nc25.png', '#eba675', 33,3)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('face-mac-NC20.jpg', '#e0a37a', 16,3)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('face-mac-nc55.jpg', '#8b4822', 21,3)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'MINERALIZE TIMECHECK LOTION', 'CT5','BR1',1035000,'HYDRATING, BLURS LINES, VISIBLY SHRINKS PORES',
'Mineralize Timecheck Lotion utilizes ingredients that fight against time. The addition of a polymer technology also creates the 
optical illusion of blurred fine lines, while helping to shrink the look of pores. Formulated with our signature Charged Water 
Technology to saturate skin with hydration and Mineral-Rich Yeast Extract to nourish complexion with a blend of essential minerals. 
Delivered in a unique gel-lotion formula that feels like a cooling, refreshing splash of water. Can be applied as a primer for 
makeup that glides like silk on top.', '2021-01-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('MOISTURIZERS-mac-mineral.jpg', 42,4)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'CLEANSE OFF OIL','CT7','BR1',760000,'REMOVES WATERPROOF MAKEUP, NATURAL OILS, GENTLE',
'An industry-strength oil-based makeup remover that is gentle on the skin. Botanically formulated with oils of olive fruit, 
evening primrose and jojoba seed and completely free of mineral oil. Massages onto skin to loosen all makeup, including waterproof
mascara. Emulsifies upon contact with water and then rinses off cleanly and easily, leaving skin feeling soft.', '2021-01-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('cleanser-mac-off-oil.jpg', 40,5)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( '316 SYNTHETIC LIP BRUSH','CT9','BR1',510000,'FOR LIQUIDS/CREAMS, TAPERED TIP, SCULPTS LIPS',
'For controlled lipstick application that comes with a metal cover. This brush has small, flat, firm fibres and a tapered tip. 
M·A·C professional brushes are hand-sculpted and assembled using the finest quality materials. They feature wood handles and 
nickel-plated brass ferrules.', '2021-01-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('access-mac-316.jpg', 17,6)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values('COLOR SENSATIONAL ULTIMATTE SLIM LIPSTICK MAKEUP','CT1', 'BR2', 210000,'Color Sensational Ultimatte slim lipstick 
delivers more intense color.','With Color Sensational Ultimatte, 
more is more! That’s more matte, more color intensity, and lightweight feel. Color Sensational delivers a lightweight blurring 
formula made with high-impact pigments in this extreme matte lipstick. Now available in a slim, luxe bullet and a full range of 
beautiful, non-drying lipstick shades. From More Berry to More Mauve and More Scarlet - nude lipstick to red lipstick - 
there’s definitely more for you to love.', '2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR, DETAILQUANTITY, IDPR)
values ('lip-Maybelline-MORE-RUBY.jpg','#b81419', 24,7)
GO
insert into IMAGES(NAMEIM,COLOR, DETAILQUANTITY, IDPR)
values ('lip-Maybelline-MORE-SCARLET.jpg','#cb220b', 17,7)
GO
insert into IMAGES(NAMEIM,COLOR, DETAILQUANTITY, IDPR)
values ('lip-Maybelline-MORE-MAUVE.jpg','#a94f63', 21,7)
GO
insert into IMAGES(NAMEIM,COLOR, DETAILQUANTITY, IDPR)
values ('lip-Maybelline-MORE-RUST.jpg','#96382e', 10,7)
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-Maybelline-RISE-TO-THE-TOP.jpg','#ad371c',30,7)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'BROW EXTENSIONS FIBER POMADE CRAYON EYEBROW MAKEUP','CT2', 'BR2',160000,
'Brow Extensions delivers thick brows instantly. Meet our first brow fiber extensions in a stick',
'Our first Brow Extensions in a stick. Meet the fiber-packed pomade crayon that delivers thick, natural-looking eyebrows instantly. 
This pomade crayon is infused with hair-like fibers that adhere to brow hairs for a full thicker brow look. 
Brow Extensions thickens as it colors and has a natural, matte finish. Get that thick natural brow look you’ve always wanted.',
'2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-maybelline-light-blonde.jpg','#a0886d',57,8)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-maybelline-black-brown.jpg','#594f45',50,8)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'FIT ME!MATTE + PORELESS FOUNDATION',
'CT3', 
'BR2',
175000,
'This lightweight foundation mattifies and refines pores and leaves a natural, seamless finish.',
'Ideal for normal to oily skin, our exclusive matte foundation formula features micro-powders to control shine and blur pores. Pore minimizing foundation. All day wear. Non-comedogenic. Dermatologist tested. Allergy tested.',
'2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-maybelline-nude-beige.jpg','#e9bf9a',51,9)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-maybelline-rich-tan.jpg','#daa58d',51,9)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Shine Sheer Shine Lipstick',
'CT1', 
'BR3',
345000,
'A pop of color, a burst of hydrating shine.',
'Glide on a pop of bright, illuminating, buildable color—a burst of sheer, brilliant, hydrating shine.
Super sleek. Super shiny. Super sexy. This is high-powered glamour, enhanced with plumping moisture.
100% of panelists demonstrated an immediate improvement in moisture.'
,'2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-estee-914unpredictable.jpg','rgb(179, 35, 26)',21,10)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-estee-913genius.jpg','rgb(188, 68, 78)',15,10)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-estee333persuasive.jpg','rgb(157, 29, 30)',21,10)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Pure Color Envy EyeShadow 5-Color Palette',
'CT2', 
'BR3',
1245000,
'A color story in a compact.',
'Five superluxe shadows in a powder so plush, it feels creamy. Each shade palette is anchored in neutrality. Nuances of tone and texture add elements of the unexpected.
Go natural, intensified or dramatic with ease—create multiple eye looks with one palette. Brighten, sculpt and define your eyes: Lighter shades lift and illuminate. Mid-tones shape and contour. Deep tones define with a smoky allure.Weightless, ultra-fine powder with intense color release. Glides on silky, blends effortlessly.',
'2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-estee-DEFIANT-NUDE.jpg','rgb(233, 210, 192)',53,11)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-estee-fiery-saffron.jpg','rgb(217, 189, 150)',54,11)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Futurist Hydra Rescue Moisturizing Makeup SPF 45',
'CT3', 
'BR3',
980000,
'Flawless makeup with serious skincare.',
'Coverage + Care: Powered with high-performance Estée Lauder skincare. Breathable, skin-loving makeup with a 12-hour radiant glow.
This Moisturizing Makeup is infused with our IonCharged Water Complex, plus probiotic technology and chia-seed extract.
The buildable medium-to-full coverage, lightweight formula immediately evens skintone, covers redness, dark spots and imperfections. Rescues skin with soothing, plumping hydration. It’s natural looking makeup that lights skin with an instant radiant glow—that lasts 12 hours. Provides broad spectrum UVA/UVB protection. Looks flawless and smooth.'
,'2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-3c2-pebble.jpg','rgb(211, 175, 161)',43,12)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-1w2-sand.jpg','rgb(226, 192, 156)',32,12)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-estee-5w1-bronze.jpg','rgb(197, 128, 86)',54,12)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Advanced Night Repair Recovery PowerFoil Mask',
'CT4', 
'BR3',
1700000,
'Innovative mask with exclusive repair technology.',
'Starting tonight, reset the look of your skin after the visible assaults of modern life with this innovative weekly treatment mask. Instantly, skin looks fresher, renewed.
2X Hyaluronic Acid. Each treatment delivers a surge of liquid revitalization, immersing skin in a double dose of Advanced Night Repair Serum is powerful moisture magnet. Also includes our proven ChronoluxCB technologies. Experience an ultimate infusion of youthful moisture.'
,'2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('mask-estee-powerfoil-mask.jpg',544,13)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Resilience Multi-Effect Night Face and Neck Creme',
'CT5', 
'BR3',
2100000,
'Intense nighttime nourishment to lift and firm.',
'This rich night creme reveals a more lifted, youthful look while you sleep. Skin feels firmer, denser as elasticity increases. Lines and wrinkles look diminished. Radiance is restored.
Skin stays intensely nourished all night, so you wake up glowing with a fresh, healthy look. Add an energizing hydration boost by using as a weekly mask. Pair with Resilience Lift Day as a 24-Hour lift system.'
,'2021-01-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('moiz-estee-tri-peptide.png',80,14)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Advanced Night Repair Serum Multi-Recovery Complex',
'CT6', 
'BR3',
2400000,
'The #1 serum in the U.S. Fight the look of multiple signs of aging.',
'Fast Visible Repair and Youth-Generating Power.
Experience the next generation of our revolutionary formula—the most comprehensive Advanced Night Repair serum ever. Patented until 2033.
Now with Chronolux Power Signal Technology, this deep- and fast-penetrating face serum reduces the look of multiple signs of aging caused by the environmental assaults of modern life. Skin looks smoother and less lined, younger, more radiant and even toned.'
,'2021-01-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-estee-ad-night-repair.jpg',80,15)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-estee-firm-lift-duo.jpg',80,15)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Advanced Night Micro Cleansing Foam',
'CT7', 
'BR3',
760000,
'Airy foam purifies skin; removes makeup & pollution.',
'Micro-purifying. Micro-revitalizing.
This conditioning formula transforms into a soft, airy foam that removes makeup and impurities, including pollution, as it purifies deep within skin is surface to improve your overall healthy look.
The high performance formula rinses easily and leaves skin feeling clean, soft and refreshed.'
,'2021-01-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-estee-cleansing-foam.jpg',80,16)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Foundation Brush',
'CT9', 
'BR3',
860000,
'Sleek brush, tapered edge for the most natural look.',
'The ultimate foundation brush for a flawless finish every time.It provides smooth, even application. The special design—sleek, with a tapered edge—makes blending easy and gives you a natural, seamless look. To use with your liquid foundation, pour a  small amount onto the back of your hand. Sweep brush across foundation and apply to face with downward strokes until the look is even and seamless. Also ideal for applying cream foundation.'
,'2021-01-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-estee-foundation-brush.jpg',80,17)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Dramatically Different Lipstick Shaping Lip Colour','CT1', 'BR4', 460000,'Rich, hydrating color infused with skin care for lips.',
'Dramatically Different Lipstick delivers more than just color. 3D pearl center core instantly sculpts and contours, providing an 
immediate appearance of a smoother pout. Over time, lip definition is improved. Available in a remarkable range of shades.', '2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-clini-barely.jpg','rgb(204, 159, 158)',12,18)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-clini-berry-freeze.jpg','rgb(170, 78, 61)',8,18)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-clini-glazed_berry.jpg','rgb(231, 126, 135)',17,18)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-clini-red-alert.jpg','rgb(196, 18, 47)',20,18)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'High Impact Waterproof Mascara','CT2', 'BR4', 460000,'Instant volume and length that resists clumping and smudging.',
'Instant volume and length that resists clumping and smudging. Our waterproof version of High Impact Mascara can stand up to heat, 
humidity, an active day. Safe for sensitive eyes and contact lens wearers. Ophthalmologist tested, too.', '2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('eye-clini-high-impact.jpg',37,19)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'NEW Even Better Foundation Broad Spectrum SPF 25','CT3', 'BR4', 966000,'Built with 3 serum technologies, 
this oil-free formula and leaves bare skin looking even better.', 'This weightless, medium-to-full foundation with 24-hour wear helps
visibly improve skin instantly and over time. SPF 25 physical sunscreens help protect skin from future discoloration. 
Clinically proven to leave bare skin looking even better—more even, smoother, and more plumped.', '2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-clinical-wn-01-flax.jpg','rgb(236, 220, 207)',25,20)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-Clini-CN10-Alabaster.jpg','rgb(240, 201, 175)',30,20)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-clinical-foundation-wn-56.jpg','rgb(229, 183, 140)',10,20)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Moisture Surge Overnight Mask','CT4', 'BR4', 850000,'Creamy, oil-free facial mask deeply moisturizes while you sleep.', 
'Did you know skin loses moisture while you sleep? This rich, penetrating night mask replenishes all night long. It soothes and 
nourishes to help skin stay hydrated. You’ll wake up to soft, dewy, glowing skin. Recommended for all skin types. Oil-Free.','2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('mask-clini-overnight-mask.jpg',120,21)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'NEW Moisture Surge 100H Auto-Replenishing Hydrator','CT5', 'BR4', 575000,'Refreshing oil-free gel-cream penetrates deep, lasts 100 hours.', 
'Lightweight oil-free formula provides hydration that goes over 10 layers deep.Delivers a 174% immediate moisture boost and keeps 
skin hydrated for 100 hours. This advanced dual-action hydrator with Auto-Replenishing Technology helps skin create its own internal
water source to continually rehydrate itself, then locks in moisture for an endlessly plump, healthy-looking glow.','2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('mois-clini-hour-gel-cream.jpg',120,22)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Clinique Smart Night Repair Treatment Retinol','CT6', 'BR4', 1590000,'Skin-repairing nighttime treatment jumpstarts the 
anti-aging process.', 
'Powered by 0.3% retinol, this creamy formula sinks in to help speed up cell turnover and visibly reduces fine lines and wrinkles. 
Skin tone looks more even, radiant, and pores look minimized. Delivers instant and lasting hydration, which helps comfort skin and 
offset dryness sometimes associated with retinol.','2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-clini-repair.jpg',30,23)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Take The Day Off Cleansing Balm','CT7', 'BR4', 715000,'Our #1 makeup remover in a silky balm formula.', 
'Lightweight makeup remover quickly dissolves tenacious eye and face makeups, sunscreens. Transforms from a solid balm into a silky 
oil upon application. Cleans thoroughly, rinses off completely. Gently helps remove the stress of pollution so skin looks younger, 
longer. Non-greasy. Non-drying.','2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-clini-cleansing-balm.jpg', 25,24)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'City Block Broad Spectrum SPF 50 Daily Energy','CT8', 'BR4', 680000,'An energizing, go-anywhere daily SPF protector for all-day defense.', 
'Daily SPF protector works all day to defend and awaken skin. Sheer and weightless. Quick absorbing and oil-free. Stop Signs 
Technology prevents signs of aging by combating a full spectrum of modern environmental aggressors including UVA/UVB and other skin 
irritants. Sunscreen ingredients such as Titanimum Dioxide, Zinc and Octinoxate provide protection against UV rays (UVA & UVB).','2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('suncreen-clini-spectrum-spf50.jpg', 75,25)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Bronzer/Blender Brush','CT9', 'BR4', 875000,'The best way to apply bronzing powder – loose, pressed and shimmering.', 
'The perfect partner for powders. Great for blending and highlighting. Unique antibacterial technology.','2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-clini-blender.jpg', 18,26)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'VisionAiry Gel Lipstick','CT1', 'BR5', 600000,'A long-lasting, full-coverage lipstick featuring innovative Triple Gel Technology.', 
'Using revolutionary Triple Gel Technology, this breakthrough formula allows high levels of pigment to converge with water for 
cushiony, comfortable, weightless color that stays put for six hours. This ultra-sleek lipstick bullet glides on to deliver bold, 
high-impact color in a single stroke.','2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-scarlet-rush.jpg','#862633', 23,27)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-202-bullet-train.jpg','#D66965', 17,27)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-209-incense-terracotta.jpg','#C26E605', 20,27)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-ruby-red.jpg','#BA0C2F', 35,27)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Kajal InkArtist - Shadow, Liner, Brow','CT2', 'BR5', 575000,'This 4-in-1 liner, kajal, eyeshadow with bold, 12-hour waterproof wear, and a weightless feel.', 
'This 4-in-1 eye pencil acts as a liner, kajal, eyeshadow, and brow color. The smudge-proof, crease-proof, waterproof, and tear-proof
formula provides high-impact pigment with an even glide and a featherweight feel. Its soft, graduated point is precise enough to 
create a thin, smooth band along the inner rim of the eye, and also wide enough to be easily swathed across the entire lid.
A detachable sharpener maintains the tip for ultimate precision, while a built-in sponge can be used to blend for a seamless, 
smoky finish.','2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-shiseido-tea-house-brown.jpg','#956C58', 25,28)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-shiseido-azuki-red.jpg','#802F2D', 15,28)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-shiseido-rose-pagoda.jpg','#9E2A2F', 10,28)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'SYNCHRO SKIN RADIANT LIFTING Foundation SPF 30','CT3', 'BR5', 1080000,'A lightweight, hydrating, liquid foundation with medium-to-full coverage.', 
'A combination of transparent pearls, radiant microcrystals, and advanced optical filters balances and adapts to any ambient lighting
condition, while an exclusive blend of humectants binds moisture to the skin for 24-hour hydration. Infused with mandarin peel 
extract to help support skin’s radiance, this weightless foundation offers instant results and lasting luminosity.
Protects with SPF30.',
'2021-01-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-shiseido-birch.jpg','#f4cca8', 25,29)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-shiseido-lace.jpg', '#f1c6a6', 30,29)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-shiseido-quarzt.jpg', '#efc7a5', 32,29)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-shiseido-alabaster.jpg', '#f8e1c0', 42,29)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Uplifting and Firming Express Eye Mask','CT4', 'BR5', 230000,'A retinol eye mask that visibly lifts and firms around the eyes in just 1 week.', 
'This retinol under eye mask visibly lifts and firms in just 1 week. Immediately see a more radiant eye area, while helping target 
dark circles, undereye bags and signs of fatigue.
Our exclusive MATSU-ProSculpt Complex helps to target the look of age-related puffiness in the eye area. For even greater results, 
use with Vital Perfection Uplifting and Firming Eye Cream before application of mask.',
'2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('mask-shi-eyemask.jpg', 95,30)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Wrinkle Smoothing Day Cream SPF 23','CT5', 'BR5', 1400000,'A daily anti-aging day moisturizer with SPF 23 that visibly corrects wrinkles.', 
'This anti-aging moisturizer visibly corrects wrinkles. ReNeura Technology+ improves skin is receptivity while KOMBU-Bounce Complex
serves as a natural wrinkle inner-filler, helping to target current and future wrinkles. The silky, smooth texture absorbs quickly to
hydrate from within and provides 24-hour moisture for smooth, resilient skin with a youthful looking radiance.',
'2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('face-shi-wrinkle.jpg', 90,31)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Wrinkle Smoothing Contour Serum','CT6', 'BR5', 1500000,'Retinol serum that enhances skin’s self-restoring power.', 
'Powered by ReNeura Technology＋ and Retinol Soft Caps, this retinol serum enhances skin’s self-restoring power to improve the 
appearance of wrinkles and skin’s resilience in just 1 week. The unique retinol capsules release and deliver fresh ingredients 
the moment you apply, helping to visibly lift deep wrinkles and sagging skin from within.',
'2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-shi-contour.jpg', 65,32)	
GO
insert into PRODUCT (NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Clarifying Cleansing Foam (for all skin types)','CT7', 'BR5', 715000,'A creamy foam cleanser that clarifies and reveals radiant skin.', 
'A creamy foam cleanser infused with effective ingredients to help remove dullness and clarify skin, revealing glowing radiance. 
Deeply cleanse, moisturize and balance skin, prepping it for further skincare treatment.
Exclusive InternalPowerResist technology strengthens skin and defends against pollutants. This cleanser foams into a rich lather 
making it ideal for all skin types. Revealing clarity for a luminous radiance.',
'2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-shi-clarifying.jpg', 115,33)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Ultimate Sun Protector Lotion SPF 50+ Sunscreen','CT8', 'BR5', 890000,'Invisible Broad Spectrum SPF 50+ face and body
sunscreen with a protective veil that becomes even more effective in heat and water.', 
'Our newest innovation builds on Shiseido WetForce Technology with the addition of HeatForce Technology. Together they create 
SynchroShield, an invisible, lightweight protective veil thats strengthened by heat and water.The silky spf 50+ sunscreen delivers
peak protection that goes on clear and rubs in quickly without any residue. For use on face and body.',
'2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('sunscreen-shi-ultimate.jpg', 52,34)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Eyelash Curler','CT9', 'BR5', 230000,'Our best-selling eye lash curler for glamorous, traffic-stopping curl.', 
'#1 Eyelash Curler in the US
Our best-selling eye lash curler for glamorous, traffic-stopping curl. The broad curve curls lashes from inner to outer corner while 
the edge-free design prevents pinching and reaches even the smallest lashes. Silicon pad curls from base to tip and includes one 
replacement pad.',
'2021-01-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-shi-Eyelash-Curler.jpg', 85,35)	
GO
insert into PRODUCT (NAMEPR, IDCTGR, IDBR, PRICE,BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'PATENT PAINT LIP LACQUER', 'CT1','BR1',510000, 'NON-STICKY 3D SHINE, WEIGHTLESS SATURATED COLOUR, NON-BLEEDING','Paint on power with Patent Paint Lip Lacquer. 
Wear your true colours on your lips. These all-new liquid lip shades are saturated with weightless, vibrant colour and powerful 
3D shine. Thanks to an innovative formula, this creamy, non-sticky, moisturizing lacquered colour doesn’t bleed or feather.', '2021-02-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lipmacSLICKFLICK.jpg','#ac2536',90,36)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lipmacMAJORGLAZER .jpg','#b25e6b',7,36)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'EYE SHADOW', 'CT2','BR1',415000,'RICH COLOUR, PROFESSIONAL, ICONIC' ,
'Behold the power of pigment. Elevate your eyes with a streak of rich, highly pigmented pressed powder. This saturated shadow 
formula stays on all day long with non-creasing, eight-hour wear. The result: potent colour payoff that applies evenly, 
blends well and can be used wet or dry. Available in a kaleidoscope of colours, textures and finishes.', '2021-02-01')
go
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('eye-mac-omega.jpg', '#cdad9a', 10,37)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('eye-mac-embark.jpg', '#805d49', 25,37)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('eye-mac-finjan.jpg', '#ad6c66', 42,37)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'STUDIO RADIANCE FACE AND BODY SHEER FOUNDATION', 'CT3','BR1',760000,'SHEER BUILDABLE COVERAGE, NATURAL RADIANT FINISH, HYDRATING/WATERPROOF',
'Long beloved on red carpets and runways around the world, our perennial Artist- and fan-favourite foundation promises to reveal – 
and never conceal – the real you with a sheer, radiant, my-skin-but-better finish. This formula provides a sheer buildable veil of 
coverage with a natural, radiant glow. It delivers refreshing, instant hydration in an ultra-light, waterproof formula with all-day 
comfort and wear. Does not cause acne.', '2021-02-01')
go
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('face-mac-n6.jpg', '#894c26', 15,38)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('face-mac-c1.jpg', '#d8a578', 30,38)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('face-mac-w1.jpg', '#e1af8c', 32,38)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values('PREP + PRIME ESSENTIAL OILS STICK','CT5','BR1',645000,'HYDRATING, MULTI-PURPOSE, PORTABLE',
'For hydration at any time, any place. In a convenient twist-up stick, this multi-purpose balm provides instant moisturization 
that’s quickly absorbed into skin with good-for-you ingredients. Can be used on hands, cuticles, face, elbows, knees…anywhere dry 
skin appears.', '2021-02-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('MOISTURIZERS-mac-oils-stick.jpg', 55,39)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'GENTLY OFF EYE AND LIP MAKEUP REMOVER','CT7','BR1',510000,'DUAL-PHASE FORMULA, GENTLE, SOOTHING',
'Oil and water do mix for twice the impact – just shake. A dual-phase formula that removes even the most tenacious waterproof 
mascara and lip colour. Gentle, non-irritating formula includes cucumber extract and Damask rose flower water to soothe and refresh. 
No need to rinse.', '2021-02-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('cleanser-mac-gentle-remover.jpg', 27,40)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( '191 SQUARE FOUNDATION BRUSH','CT9', 'BR1',1370000,'FOR FOUNDATION, FLAT SQUARE-SHAPED, SHADES FACE',
'A large, flat, square-shaped synthetic-fibre brush with a fine firm edge for even distribution and blending of liquid, 
emulsion or cream products on the face or body. The square shape allows for more control on the level of coverage, which enables 
the flexibility to work on applying and building ultra-sheer layers. M·A·C professional brushes are hand-sculpted and assembled 
using the finest quality materials. They feature wood handles and nickel-plated brass ferrules.', '2021-02-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('access-mac-191.jpg', 12,41)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'SUPER STAY INK CRAYON LIPSTICK, MATTE LONGWEAR','CT1', 'BR2', 220000,'Super Stay Ink Crayon is a long-lasting lip crayon.','With Color Sensational Ultimatte, 
more is more! That’s more matte, more color intensity, and lightweight feel.Color Sensational delivers a lightweight blurring 
formula made with high-impact pigments in this extreme matte lipstick. Now available in a slim, luxe bullet and a full range of 
beautiful, non-drying lipstick shades. From More Berry to More Mauve and More Scarlet - nude lipstick to red lipstick - 
there’s definitely more for you to love.', '2021-02-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-maybelline-keep-it-fun.jpg','#bb6d7d',50,42)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-maybelline-make-it-happen.jpg','#732933',10,42)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'LASH SENSATIONAL SKY HIGH WATERPROOF MASCARA',
'CT2', 
'BR2',
240000,
'Sky High lengthening and volume mascara for sky high lash impact from every angle',
'Sky High lash impact from every angle! Lash Sensational Sky High mascara delivers full volume and limitless length. 
Exclusive Flex Tower mascara brush bends to volumize and extend every single lash from root to tip. Waterproof mascara formula 
infused with bamboo extract and fibers for long, full & lightweight lashes, that do not flake or smudge.
Suitable for sensitive eyes and contact lens wearers. Removes easily with waterproof eye makeup remover.',
'2021-02-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-maybelline-brownish-black.jpg','#241616',95,43)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'LASTING FIX BANANA POWDER',
'CT3', 
'BR2',
175000,
'Lasting Fix Matte Setting Powder is now in shade brightening Banana for a soft focused effect.',
'Lasting Fix All Day Matte Setting Powder is now available in shade brightening Banana. Bring on serious staying power with this mattifyng microfine powder that creates a soft focus effect as it sets makeup. This powder will keep your makeup locked down all day. Set your makeup look, achieve a matte finish, and minimize shine. This loose setting powder glides onto the skin, extending the wear of your foundation, while creating a flawless, matte finish that lasts.',
'2021-02-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-maybelline-banana-powder.jpg','#f7e8c1',52,44)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Pure Color Love Lipstick',
'CT1', 
'BR3',
550000,
'Ultra Mattes, Shimmer Pearls, Cool Chromes, Edgy Cremes.',
'Daring. Vibrant. Striking. Sublime. Color has never felt so fun!
There are no rules in Love–so play, mix and remix to make every look your very own.
Fly solo with a single shade. Layer up for custom color or selfie-worthy styling—see How to Use below for a few looks to start you off. Pure Color Love is packed with a superfruit cocktail of Pomegranate, Mango and Açai power oils. Lips feel smooth, soft and moisturized. The lipstick texture feels weightless, yet wonderful.'
,'2021-02-01')
go

insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-estee-FEMME-BOT.jpg','rgb(107, 23, 46)',210,45)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-estee-405.jpg','rgb(145, 85, 115)',15,45)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Double Wear Stay-in-Place Eye Pencil',
'CT2', 
'BR3',
1245000,
'24-hour wear. Waterproof.',
'Wears for 24 hours. Sets in seconds.This long-wearing, waterproof eye pencil lines and defines with smooth, even color that looks fresh all day and night.
The lightweight, creamy formula glides on effortlessly. Rich, stay-true color won not smudge.Double-ended pencil has smudger on one end, color on the other. Sharpens easily with the Estée Lauder Pencil Sharpener.'
,'2021-02-01')
go

insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-estee-onyx.jpg','rgb(27, 34, 37)',43,46)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-estee-BURGUNDY-SUEDE.jpg','rgb(92, 62, 63)',32,46)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-estee-night-diamond.jpg','rgb(87, 81, 81)',54,46)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Double Wear Stay-in-Place Matte Powder Foundation',
'CT3', 
'BR3',
950000,
'Versatile powder to wear as foundation, or over it.',
'One powder. Multi uses. Custom coverage.
Dress it up or down. Wear it as your foundation, or over it. Full on or for touch ups. Lasts all day…or all night. Versatile formula is silky soft, weightless, flawless. Controls oil and shine. Stays color true.
Customize your coverage with a flip of the two-sided applicator. Use the sponge side for full coverage, the velvety side for medium. Wet the applicator for sheer coverage. For the ultimate matte finish, use a powder brush to sweep it over Double Wear Stay-in-Place Makeup as a setting powder.'
,'2021-02-01')
go

insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-4n1-shell-beige.jpg','rgb(246, 204, 162)',65,47)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-7n1-deep-amber.jpg','rgb(181, 117, 74)',52,47)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-2w1-dawn.jpg','rgb(251, 214, 179)',76,47)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Advanced Night Repair Recovery Eye Mask',
'CT4', 
'BR3',
1080000,
'Rejuvenates the look and feel of your eyes.',
'A revolution in repair for fresh, youthful-looking eyes.
Starting tonight, rejuvenate the look and feel of your eyes after the stresses of modern life—from long days to lack of sleep, even pollution.
Our Worldwide First: The only eye mask infused with Advanced Night Repair technology. Instantly, your eye area feels cool and refreshed. In just 10 minutes, eyes look more rested, renewed. Fine, dry lines are plumped as skin is drenched with hydration. Eyes look radiant, infused with luminous youth.'
,'2021-02-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('mask-estee-eye-mask.png',44,48)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'DayWear Multi-Protection 24H-Moisture Creme SPF 15',
'CT5', 
'BR3',
1300000,
'Helps prevent and diminish first signs of aging.',
'This high-performance moisturizer defends against signs of premature aging—and diminishes their appearance—with our most effective anti-oxidant power ever.
So hydrating, it infuses skin with an intense surge of moisture that lasts—24 hours.
DayWear includes our proven Super Anti-Oxidant Complex and Broad Spectrum sunscreen. It reduces the first signs of aging, like dullness and fine, dry lines. Refreshes skin with lasting hydration.'
,'2021-02-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('moiz-estee-daywear.jpg',80,49)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Perfectionist Pro Rapid Firm + Lift Treatment Duo',
'CT6', 
'BR3',
4200000,
'Value set of our superstar Firm + Lift serum.',
'Get the perfect pair: two bottles of Perfectionist Pro.
This breakthrough, fast-penetrating formula helps strengthen your skin is vital support network, for an overall more youthful, lifted look. Multiple facial zones—along the jawline, cheeks and even stubborn laugh lines—feel firmer.'
,'2021-02-01')

go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-estee-firm-lift-duo.jpg',80,50)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Soft Clean Moisture Rich Foaming Cleanser',
'CT7', 
'BR3',
600000,
'Foams into rich lather. Leaves skin soft, satisfied.',
'Luxurious creme foams into a moisture-rich lather to gently clean, calm and soften skin. Surrounds you with a sense of total satisfaction.
Specially cushioning for dry skin. Gentle yet effective. Helps preserve skin is moisture barrier. Skin feels pampered, soft, comfortably clean. Includes soothing extracts of Passion Flower and Edelweiss.','2021-02-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-estee-soft-clean.jpg',80,51)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Concealer Brush',
'CT9', 
'BR3',
980000,
'Small, tapered brush. Precise concealing, blending.',
'This small, tapered brush is designed to precisely apply and easily blend concealer.
Expertly covers undereye circles and other flaws. Use the brush tip to pat concealer into desired area until it melts into skin. For best results, apply concealer over foundation. Make sure to blend edges for a seamless look.'
,'2021-02-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('eccess-estee-concealer-brush.jpg',80,52)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Chubby Stick Moisturizing Lip Colour Balm','CT1', 'BR4', 575000,'A brilliant range of mistake-proof shades to mix and layer',
'Super-nourishing balm is loaded with mango and shea butters. Just what dry, delicate lips need to feel comfortably soft and smooth. 
Natural-looking lip tints have a subtle sheen.', '2021-02-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-clinique-mega-melon.png','rgb(196, 90, 91)',23,53)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-clini-risin.jpg','rgb(133, 63, 54)',30,53)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-clini-chunky.jpg','rgb(192, 65, 86)',25,53)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'High Impact Curling Mascara','CT2', 'BR4', 460000,' Smudge, flake, smear-resistant for up to 24 hours.',
'Coaxes lashes to their longest, boldest, most upturned look yet, without a pinch, pull, tug or tear. Arched wand scoops up, 
lifts up every last lash. Smudge, flake, smear-resistant for up to 24 eye-opening hours. Remove easily with warm water. 
Ophthalmologist tested.', '2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('eye-clini-curling.jpg',37,54)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Even Better Makeup Broad Spectrum SPF 15','CT3', 'BR4', 715000,'Dermatologist-developed foundation visibly reduces 
dark spots in 12 weeks.', 'Helps create a brighter skin tone. After 12 weeks of daily wear, dark spots from acne, age, and sun damage
are reduced. Creamy formula hydrates and smooths, gives skin a natural finish. Broad spectrum SPF 15 protects against future
discoloration. Stay-true pigments won’t change color on your skin. Sweat and humidity-resistant.', '2021-02-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-clini-wn4-bone.jpg','rgb(241, 207, 178)',32,55)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-clinique-cn-28-ivory.jpg','rgb(232, 188, 158)',40,55)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-clini-wn-64-butterscotch.jpg','rgb(224, 173, 132)',55,55)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'City Block Purifying Charcoal Clay Mask + Scrub','CT4', 'BR4', 690000,'A 5-minute dual-action detoxifying and exfoliating clay mask.', 
'Purifies and polishes skin for a delightful deep-clean treatment. Natural bamboo charcoal and kaolin clay help remove pollution 
and impurities, while natural silica beads gently refine texture.','2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('mask-clini-city-block.jpg',170,56)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Moisture Surge 72H Lipid-Replenishing Hydrator','CT5', 'BR4', 575000,'Rich cream-gel delivers 72-hour hydration for velvety-smooth skin.', 
'Our richest formula yet sets non-stop hydration into motion with the help of activated aloe water and caffeine. Then locks it in with 
a trio of lipids, strengthening skin’s barrier to keep moisture in and helps keep aggressors out. Keeps skin hydrated for 72 hours, 
leaving it glowing, plump, and velvety-smooth. Calming cica helps soothe and comfort dry or dehydrated skin.','2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('moisture-clini-lipid-hydrator.jpg',89,57)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Even Better Clinical Radical Dark Spot Corrector Interrupter','CT6', 'BR4', 1255000,'Powerful brightening serum helps 
visibly correct discoloration.', 
'Our most powerful brightening serum helps visibly correct discoloration, such as acne marks, while interrupting the look of future 
dark spots. 94% demonstrated an improvement in radiance and visible skin tone, including acne marks, in 8 weeks. See a -39% visible 
reduction in dark spots in 12 weeks.','2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-clinical-interrupter.jpg', 78,58)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'All About Clean Liquid Facial Soap','CT7', 'BR4', 440000,'Dermatologist-developed liquid soap cleanses gently yet thoroughly.', 
'Soft, non-drying lather loosens surface flakes, removes dirt and debris, and protects skin’s natural moisture balance.
Quick-rinsing formula leaves skin clean, comfortable, refreshed – never taut or dry.
Preps skin for the exfoliating action of Step 2, Clarifying Lotion.Formulated with sucrose, known to calm and soothe skin.','2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-clini-facial-soap-mild.jpg', 30,59)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values('Broad Spectrum SPF 50 Sunscreen Face Cream','CT8', 'BR4', 655000,'With SolarSmart protection and repair. High-level UVA/UVB defense. Oil-free.', 
'Innovative SolarSmart technology stabilizes high-level protection against the aging and burning effects of UVA and UVB rays. 
Triggers a repair that helps prevent signs of aging. With solar-activated antioxidants that help prevent visible damage. 
Gentle enough for sensitive skins. Dermatologist tested. Oil-free.','2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('suncsreen-clini-broad.jpg', 60,60)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Foundation Buff Brush','CT9', 'BR4', 945000,'Versatile brush can be used with all Clinique liquid, powder, cream and stick foundations.', 
'Versatile brush with densely-packed bristles gently buffs foundation into skin. Creates a smooth, even canvas. Can be used with all
Clinique liquid, powder, cream and stick foundations. Clinique is unique antibacterial technology helps ensure the highest level of 
hygiene.','2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-clini-buff.jpg', 10,61)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'LacquerInk Lip Shine','CT1', 'BR5', 600000,'This featherweight formula that never leaves lips feeling dry or sticky.', 
'The unique blend of oils in this hybrid formula offers the shine and comfort of a gloss, while smoothing polymers provide the 
durable, hydrating color of a lipstick. A custom, concave applicator hugs the contours of the mouth and dispenses the perfect 
amount of pigment that can be worn alone or layered over other lip products for extra dimension and sheen. 
This full-coverage fluid deposits inky color with a vivid, vinyl finish. Dermatologist-tested.','2021-02-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-natural-pink.jpg','#AC145A', 25,62)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-coral-spark.jpg','#FF585D', 18,62)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-vinyl-nude-peach.jpg','#D6938A', 27,62)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Brow InkTrio','CT2', 'BR5', 570000,'A 3-in-1 pencil, powder, and brush designed to effortlessly balance, fill, and define brows.', 
'This 3-in-1 tool features a slim, retractable pencil that defines and shapes brows, creating a natural look with ultra-fine 
hair-like strokes. The center opens to reveal a sponge-tip applicator pre-loaded with a featherweight powder that effortlessly 
fills in sparse areas and adds depth minus hard edges. Finally, a built-in brush conveniently blends and grooms for a polished finish. 
This long-wear formula resists sweat, smudging, and water. Available in four neutral shades that suit every skin tone and hair color.',
'2021-02-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-shiseido-taupe.jpg','#9A7F61', 55,63)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-shiseido-ebony.jpg','#473729', 30,63)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-shiseido-blonde.jpg','#B7916C', 42,63)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'SYNCHRO SKIN SELF-REFRESHING Concealer','CT3', 'BR5', 1180000,'A liquid concealer that diminishes the appearance of 
imperfections. 24-hour wear.', 
'A SHISEIDO first in concealer that self-refreshes nonstop with ActiveForce technology. Our long-wearing concealer helps resist heat,
oil, humidity, and facial movement to maintain coverage that lasts 24 hours. Brighten under-eye fatigue and dullness for an instantly
fresher look. Immediately diminish the appearance of dark circles, spots, redness and blemishes. Weightless. Breathable. Blendable.',
'2021-02-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-shiseido-Light.jpg','#e8bc92', 50,64)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-shiseido-Fair.jpg','#eac2a6', 30,64)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-shiseido-Medium.jpg','#e5aa7b', 44,64)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Power Brightening Mask','CT4', 'BR5', 270000,'Powerful brightening mask to target spots and discoloration.', 
'A powerful brightening face mask inspired by iontophoresis, a beauty treatment that saturates skin with a generous amount of 
beneficial ingredients to target spots and discoloration. A brilliant solution for radiant skin while diminishing the appearance of 
dark spots. Skin is bright, refreshed and moisturized.',
'2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('mask-shi-powermask.jpg', 80,65)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Uplifting and Firming Cream Enriched','CT5', 'BR5', 2900000,'Visibly lift skin in just 1 week, and reveal a dramatically firmer, revitalized complexion.', 
'Experience visibly lifted skin in just 1 week. This scientifically advanced, silky moisturizer helps visibly offset the effects of 
aging in record time. Skin feels firm and sculpted with renewed fullness and bounce.
Our exclusive KURENAI-TruLift Complex and ReNeura Technology++ strengthens skin’s natural support and improves the appearances of 
facial contours and definition. VP8, a blend of 5 antioxidant ingredients, provides added protection for skin. Powerful renewal for
youthful-looking skin.',
'2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('face-shi-firming.jpg', 75,66)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Power Infusing Concentrate - Floral Limited Edition','CT6', 'BR5', 3100000,'Celebrate the Spring season with a limited edition Ultimune serum', 
'Our #1 serum with ImuGeneration Technology is powered by antioxidant-rich reishi mushroom and iris root extracts to strengthen skin,
restore firmness and defend against daily damage for skin that’s 28% stronger in just 1 week. Skin looks even smoother, firmer, 
more hydrated and resilient.
The formula features a dewy texture that sinks quickly into skin for a silky smooth fresh feeling. Use Ultimune as a pre-treatment 
to enhance the efficacy of your moisturizer or serum. See makeup apply more evenly and flawlessly over softer skin.',
'2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-shi-floral.jpg', 25,67)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Perfect Cleansing Oil','CT7', 'BR5', 700000,'Lightweight cleansing oil to thoroughly remove dirt and makeup.', 
'A comfortable, lightweight cleansing oil with Shiseido original Gentle Quick-Removing Technology that can be used on wet or dry skin.
Rapidly reaches deep down into the pores to thoroughly remove dirt and makeup. Quickly lifts base makeup and waterproof eye makeup.
Rinses off quickly, leaving a non-greasy, dewy finish.',
'2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-shi-oil.jpg', 78,68)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Sports HydroBB Compact SPF 50+','CT8', 'BR5', 680000,'A travel-friendly compact foundation with SPF that delivers a powdery finish.', 
'Compact foundation that “wicks” away sweat to prevent makeup from getting sticky or fading while reacting with water to improve UV 
protection. Helps give skin a natural, lustrous & contoured look for long wear that outlasts the sun and outdoor activities.',
'2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('sunsreen-shi-compact.jpg', 87,69)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Synchro Skin Puff (for Pressed Powder)','CT9', 'BR5', 168000,'This luxurious puff has been specifically designed to deliver smooth, 
even coverage with loose and pressed powders.', 
'This puff has been specifically designed to deliver smooth, even coverage with loose and pressed powders. 
Achieve professional-quality results. Super soft texture feels luxurious on skin.',
'2021-02-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-shi-puff.jpg', 35,70)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'LIPGLASS', 'CT1','BR1',415000, 'GLASS-LIKE SHINE, HIGH COVERAGE, M·A·C HERITAGE' ,
'A unique lip gloss available in a wide variety of colours that can create a high-gloss, glass-like finish or a subtle sheen. 
Designed to be worn on its own, over lip pencil or lipstick, it is the perfect product for creating shine that lasts.
Its pigmented, very shiny and can impart subtle or dramatic colour. It contains jojoba oil to help soften and condition the lips.', '2021-03-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR)  
values ('lipmaccandybox.jpg','#e68f95',20,71)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR)  
values ('lipmacrubywoo.jpg','#96051f',50,71)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'EYE BROWS BIG BOOST FIBRE GEL', 'CT2','BR1',530000,'ADDS VOLUME WITH MICROFIBRES, GROOMS/SHAPES/BUILDS BROWS, 24-HOUR WATERPROOF WEAR',
'Boost your brow game. Give brows a voluminous boost in a single swoop with this 24-hour Fibre Gel for perfectly polished to 
expertly untamed looks. This tinted formula effortlessly creates fuller, thicker, fluffier brows with small synthetic microfibres 
that build, define and shape brow hairs. Its waterproof, sweatproof formula ensures colour and volume are locked in all day and night.',
'2021-03-01')
go
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('eye-mac-fling.jpg', '#a27e68', 35,72)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('eye-mac-strut.jpg', '#ab6146', 22,72)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'STUDIO WATERWEIGHT SPF 30 FOUNDATION', 'CT3','BR1',830000,'SHEER COVERAGE, SATIN FINISH, HYDRATING',
'This hydrating formula contains a moisture fusion complex to immediately moisturize and feed the skin. Protects with SPF 30 and is 
perfect for all skin types. It offers all-day wear and sheer to medium coverage in stay-true colour.', '2021-03-01')
go
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('face-mac-nc35.jpg', '#ebb491', 28,73)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('face-mac-nw30.jpg', '#e5a88e', 35,73)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'MINERALIZE RESET & REVIVE CHARCOAL MASK','CT4','BR1',760000,'a charcoal-infused mask that purifies pores, penetrating deeply and eliminating impurities.
',
'a charcoal-infused mask that purifies pores, penetrating deeply and eliminating impurities.
', '2021-03-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('macmask.jpg', 35,74)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'MINERALIZE CHARGED WATER MOISTURE GEL','CT5','BR1',920000,'HYDRATING, SOOTHING, SOFTENS SKIN',
'An ultra-light, gel-like cream that absorbs instantly to give skin hydration. Infused with our Super-Duo Charged Water technology, 
this formula leaves skin more supple and luminous.', '2021-03-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('MOISTURIZERS-mac-water-gel.jpg', 35,75)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'MINERALIZE VOLCANIC ASH EXFOLIATOR','CT7','BR1',760000,'EXFOLIATING, CONTROLS OIL, HYDRATING',
'A dual-purpose cleansing and exfoliating scrub that blends natural volcanic ash with fine sugar crystals. Highly effective, 
the mineral-rich, concentrated formula foams on to refine and unclog the skin, leaving skin feeling soft and comfortably clean. 
Rinses off with warm water. No need to rinse.', '2021-03-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('cleanser-mac-exfloliator.jpg', 27,76)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( '170 SYNTHETIC ROUNDED SLANT BRUSH','CT9', 'BR1',1370000,'FOR CREAM/LIQUID FOUNDATION, SLANTED DOME SHAPE, 
BUFFS FOUNDATION INTO SKIN','Our global best-selling brush is a must-have in every makeup bag. It’s ideal for applying, buffing and blending absolutely any 
form of foundation or primer. Quickly achieve maximum coverage with a polished finish. This brush is perfect for beginners and 
experienced makeup users alike. Our 100% synthetic vegan brushes incorporate the latest innovations in fibre technology for superior 
performance and improved longevity.', '2021-03-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('access-mac-170.png', 22,77)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'COLOR SENSATIONAL MADE FOR ALL LIPSTICK','CT1', 'BR2', 175000,'Made For All Lipstick makeup features specially selected 
and obsessively tested pigments','Don’t know what shade complements your skin tone? Meet Maybelline’s game-changing lipstick! 
Created using specially selected pigments and tested on 50 diverse skin tones, Color Sensational Made For All Lipstick features
collectible universal shades that look sensational on all, taking the guesswork out of your lipstick shopping experience. 
Made For All features our trusted satin and matte formulas with honey nectar for a smooth and comfortable feel.', '2021-03-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-maybelline-red-for-you.jpg','#af262d',14,78)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-Maybelline-Ruby-For-Me.jpg','#91141c',95,78)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-maybelline-mauve-for-you.jpg','#a65252',95,78)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'NUDES OF NEW YORK 16 PAN EYESHADOW PALETTE',
'CT2', 
'BR2',
250000,
'Nudes of New York is first custom-designed eyeshadow palette made to flatter all complexions.',
'This Nudes of New York eyeshadow palette is our first universal palette featuring curated shades that flatter all skin tones as 
well as every complexion. Creamy formula for texture and color that doesn’t look chalky or dull. 
Featuring 16 neutral eyeshadow shades in all of your favorite finishes, from matte eyeshadow to shimmer.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('eye-Maybelline-Nudes-Of-NY.jpg',45,79)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'SUPERSTAY FULL COVERAGE POWDER FOUNDATION MAKEUP',
'CT3', 
'BR2',
235000,
'A high-pigment formula that achieves a full-coverage finish that lasts all day.',
'Packed with color-matching pigments, this long-lasting formula delivers our highest foundation coverage ever in a powder! 
This full-coverage powder makeup has a creamy texture that is easily blendable and glides onto the skin for a matte finish. 
From Classic Ivory and Fair Porcelain to Golden Caramel and Java, this high-coverage powder foundation is available in an extensive
range of complexion-matching shades.'
,'2021-03-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-Maybelline-Sun-Golden.jpg','#e3b98f',21,80)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-Maybelline-Golden-Caramel.jpg','#e0bb84',15,80)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-Maybelline-Buff-Beige.jpg','#f2dfce',135,80)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Pure Color Envy Matte Sculpting Lipstick',
'CT1', 
'BR3',
760000,
'Statement-making creme matte color.',
'Creamy. Matte. Intense. Pout-provoking. Saturates lips with undeniably daring matte color—in one stroke. Lightweight, ultra-creamy formula glides on effortlessly, covers evenly. Sensually soft and smooth, luxuriously comfortable.
The lipstick bullet is shaped to sculpt the curves of your lips. The case feels like luxury in your hands. And with one click, case closed',
'2021-03-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-estee-420 REBELLIOUS-ROSE .jpg','rgb(158, 67, 76)',53,81)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-estee-120-irrepressible.jpg','rgb(142, 30, 21)',54,81)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-estee-333-persuasive.jpg','rgb(189, 75, 67)',87,81)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Featherlight Brow Enhancer',
'CT2', 
'BR3',
890000,
'Ultra-fine marker makes your best brows easy.',
'On point. Feather-light. Feather-soft. Enhance the natural beauty of your brows with ultra-fine strokes for a fuller look. Long-wearing buildable shades add just the right color intensity for the brows you want now. Precision-tip marker makes application easy, whether you want to fill in sparse areas, contour your arch or add definition to any brow look. Once set, the formula is fade-proof and smudge-proof all day. Sweat-, humidity-, and water-resistant.'
,'2021-03-01')
go

insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-estee-blonde.jpg','rgb(117, 105, 91)',43,82)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-estee-chestnut.jpg','rgb(92, 85, 74)',32,82)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-estee-dark-brunette.jpg','rgb(102, 86, 73)',54,82)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Pure Color Envy Sculpting Blush',
'CT3', 
'BR3',
760000,
'A rush of fresh, radiant color for cheeks.',
'Sculpt. Define. Glow. Sweep on this ultra-silky, luxurious powder for enhanced definition and a healthy-looking glow.Brush included.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-PINK TEASE.jpg','rgb(233, 140, 167)',43,83)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-pink-kiss.jpg','rgb(177, 84, 87)',24,83)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-wild-sunset.jpg','rgb(229, 113, 108)',65,83)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'RE-NUTRIV Hydrating Foam Cleanser',
'CT7', 
'BR3',
600000,
'Richly foams, pampers as it cleans.',
'Indulge your senses with this exquisitely rich foaming cleanser. It thoroughly yet gently washes away impurities and makeup to leave skin feeling soft and smooth.
It’s the ideal beginning for your luxury skincare ritual, preparing skin to optimize the benefits of the treatments that follow.This is the pampering cleanser your skin has been looking for.'
,'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-estee-re-nutriv.jpg',80,84)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Pencil Sharpener',
'CT9', 
'BR3',
235000,
'Fits all Estée Lauder lip and eye pencils.',
'Multi-sharpening tool fits all Estee Lauder lip and eye pencils.
Precision sharpener catches shavings for easy disposal. Different size openings fit any pencil.
With just a quick twist your pencil is perfectly sharp.'
,'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-estee-pencil-sharpener.jpg',80,85)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Clinique Pop Lip Colour + Primer','CT1', 'BR4', 575000,'Rich colour plus smoothing primer in one. Keeps lips comfortably moisturized.',
'Luxurious yet weightless formula merges bold, saturated colour with a smoothing primer. Glides on effortlessly to a modern-velvet
finish. Colour stays true, keeps lips comfortably moisturized.', '2021-03-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-clini-love-pop.jpg','rgb(141, 57, 73)',25,86)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-clini-passion-pop.jpg','rgb(117, 13, 21)',30,86)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Pretty Easy Liquid Eyelining Pen','CT2', 'BR4', 530000,'All the drama of a liquid eyeliner without the drama of putting it on.',
'Clinique mistake-proof pen creates a clean line in one steady sweep. Tapered, precision brush paints on pure, deep colour from 
thin to thick. 24-hour smudge and budge-resistant wear. Ophthalmologist Tested. Allergy Tested. 100% Fragrance Free.', '2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('eye-clini-lining.jpg',40,87)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Even Better Glow Makeup Broad Spectrum SPF 15','CT3', 'BR4', 715000,'Dermatologist-developed foundation instantly 
perfects', 'Instantly creates a natural radiance with subtle luminizing pigments. Vitamins C and E help create a brighter skin tone. 
Broad spectrum SPF 15 protects against future darkening.Stay-true pigments won’t change color on your skin, for flawless, 
undetectable coverage.', '2021-03-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-clini-better-glow-cn58.jpg','rgb(217, 159, 110)',60,88)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-clini-better-glow-wn30.jpg','rgb(209, 149, 103)',70,88)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-clini-better-glow-cn40.jpg','rgb(215, 166, 129)',65,88)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Dramatically Different Moisturizing Lotion+','CT5', 'BR4', 680000,'Dermatologist-developed face moisturizer softens, smooths, improves.', 
'Silky lotion delivers 8-hour hydration. Slips on easily, absorbs quickly. Helps strengthen skin’s own moisture barrier so more 
moisture stays in. Skin that holds onto moisture has a youthful-looking glow.','2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('moisturising-clini-lotion-plus.jpg',55,89)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Clinique Smart Custom-Repair Serum','CT6', 'BR4', 1430000,'Potent serum visibly improves major signs of aging.', 
'Use it consistently twice a day and see remarkable improvements, including a more uniform tone, refined texture, and visibly 
diminished lines.Patented Clinique Smart technology delivers custom repair for the damage unique to your skin. A blend of Peptides, 
Glucosamine and Salicylic Acid help refine the look of fine lines. ','2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-clinique-repair-luxury.jpg', 65,90)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'All About Clean Rinse-Off Foaming Cleanser','CT7', 'BR4', 520000,'Cream-mousse cleanser gently and effectively rinses away makeup.', 
'Cream-mousse cleanser gently and effectively rinses away makeup. Purifying cleanser lathers into a rich foam to rinse away 
pollution, dirt, excess oil, long-wearing makeup and sunscreen quickly, gently, effectively. Leaves oily skin feeling fresh and clean.
Non-drying. Non-stripping. Formulated with glycerine and hyaluronic acid for a softer, more conditioning cleanse.','2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-clini-foaming-cleanser.jpg', 48,91)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'SPF 50 Mineral Sunscreen Fluid For Face','CT8', 'BR4', 690000,'Ultra-lightweight, virtually invisible 100% mineral sunscreen for your face. Oil-free.', 
'Invisible Shield Technology forms a protective veil that is virtually invisible on all skin tones. Gentle enough to use around 
the eye area, too. Oil-free. Safe to use on children ages 6 months and up.','2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('sunscreen-clini-mineral.jpg', 83,92)	
GO
insert into PRODUCT (NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'City Block Sheer Oil-Free Daily Broad Spectrum SPF 25','CT8', 'BR4', 645000,'Sheer UVA/UVB daily sun protection with no chemical sunscreens.', 
'Lightweight formula helps wick away perspiration and absorb excess oil. Perfect alone or as an invisible makeup primer.
No chemical sunscreens. Appropriate for eye area and sensitive skins. Ophthalmologist tested.','2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('sunscreen-clini-city-block.jpg', 65,93)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values('Concealer Brush','CT9', 'BR4', 530000,'Slim, tapered design for spot application and smooth, even blending of concealer.', 
'Tapered design for spot application and even blending of concealer. Use pointed tip to help camouflage small imperfections, 
flat side for larger areas: undereye circles, uneven skin tone. Unique antibacterial technology helps keep brush irritant-free.','2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-clini-concealer.jpg', 22,94)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'LipLiner InkDuo – Prime + Line','CT1', 'BR5', 600000,'A two-in-one tool that primes and shades lips for long lasting, 8 hour wear.', 
'A long lasting lip liner to enhance or correct your lip shape for a perfectly defined look. The automatic pencil lines,
defines and precisely fills your lips with color. Glides on smoothly and effortlessly to shape, shade, or color lips.
Weightless comfort. Bold color payoff. Matte finish.','2021-03-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-true-red.jpg','#b61d29', 45,95)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-09Scarlet.jpg','#a52f3e', 30,95)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'ImperialLash MascaraInk Waterproof','CT2', 'BR5', 575000,'This waterproof mascara lends lashes length, volume, and definition that lasts all day without smudging.', 
'This waterproof mascara give lashes major lift, length, volume, and definition. The innovative brush features a rigid core 
surrounded by flexible silicone bristles and a unique crown tip that can grab hard-to-reach lashes near the inner corners of eyes 
and bulk up bottom lashes minus clumps. The ultra-fine crushed pigments and precise blend of waxes wrap each lash in a weightless,
smudge-proof, clump-proof formula that lasts all day. Available in black. Dermatologist and ophthalmologist-tested.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('eye-shiseido-mascara.jpg', 45,96)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Synchro Skin Self-Refreshing Custom Finish Powder Foundation','CT3', 'BR5', 1020000,'A creamy, powder foundation you can apply wet or dry for a customized, natural finish.', 
'A SHISEIDO first in foundation, with ActiveForce technology, that self-refreshes nonstop so you maintain a just-applied, flawless 
finish that lasts 24 hours. Our long-wear creamy, powder foundation synchronizes with skin and helps resist heat, humidity, oil and 
motion. Apply wet or dry for customized coverage and a natural finish. Skin looks and feels fresh all day. Weightless comfort. 
Breathable. Blendable. Buildable.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-shiseido-opal.jpg','#efc49b', 42,97)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-shiseido-foundation-quarzt.jpg','#ddae88', 38,97)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-shiseido-shell.jpg','#e8b88e', 25,97)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Overnight Cream & Mask','CT4', 'BR5', 2300000,'A rich and comforting night face cream that does double duty as an 
intensive brightening treatment.', 
'Concentrating on skin is nighttime process, this cream moisturizes and visibly brightens skin and diminishes the look of dark
spots and unevenness. Skin is left looking bright, vibrant.
Featuring ReNeura Technology+: By helping improve skin receptivity, ReNeura Technology+™ helps to awaken and maintain the 
effectiveness of your treatment over time.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('mask-shi-overnight.jpg', 110,98)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Advanced Super Revitalizing Cream','CT5', 'BR5', 1750000,'High-performance anti-aging cream for resilient-looking smooth skin.', 
'Super Revitalizing Cream reveals beautifully resilient-looking smooth skin and creates the foundation for a more youthful look.
Skin becomes visibly refined while the appearance of fine lines and wrinkles are diminished. Skin feels dewy, soft and fully
moisturized. Skin feels dewy and soft while the cream works to diminish the appearance of fine lines and wrinkles.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('face-shi-super.jpg', 89,99)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Legendary Enmei Ultimate Luminance Serum','CT6', 'BR5', 5100000,'A luxurious face serum that visibly improves skin.', 
'This luxurious face serum is formulated from the Enmei herb, hand-picked from Japans lush nature on tenshanichi,
the most auspicious day of the Japanese calendar. Treasured Green Silk encourages the vitalizing forces that renew beautifully 
looking skin. A combination of traditional Japanese aesthetics, breakthrough technology, and ancient botanical wonders make this 
serum the most precious for improving skin quality.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-shi-luminace.jpg', 55,100)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values('Power Infusing Concentrate','CT6', 'BR5', 2350000,'Strengthen and defend skin against daily damage and premature aging with our #1 serum.', 
'Ultimune hydrates and defends skin against the effects of stress, pollution, and urban life. Powered by antioxidant Reishi Mushroom
and Iris Root Extract, this concentrated daily treatment fends off free radicals shielding complexions from the oxidative distress
that leads to premature aging. Our exclusive ImuGeneration Technology fortifies skin, helping it to help itself.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-shi-infusing.jpg', 70,101)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Extra Rich Cleansing Foam','CT7', 'BR5', 1200000,'An ultra-rich creamy anti-aging cleansing foam that removes impurities 
while keeping skin’s moisture balance.', 
'A luxurious, rich creamy foaming cleanser with anti-aging ingredients that effectively removes impurities while retaining skin’s 
essential moisture, leaving a fresh, smooth look and feel. Prepares skin to better absorb benefits of following treatments.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-shi-extra.jpg', 60,102)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Sports HydroBB Compact SPF 50+','CT8', 'BR5', 680000,'A travel-friendly compact foundation with SPF that delivers a powdery finish.', 
'Compact foundation that “wicks” away sweat to prevent makeup from getting sticky or fading while reacting with water to improve UV 
protection. Helps give skin a natural, lustrous & contoured look for long wear that outlasts the sun and outdoor activities.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('sunsreen-shi-compact.jpg', 87,103)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Synchro Skin Puff (for Pressed Powder)','CT9', 'BR5', 168000,'This luxurious puff has been specifically designed to deliver smooth, 
even coverage with loose and pressed powders.', 
'This puff has been specifically designed to deliver smooth, even coverage with loose and pressed powders. 
Achieve professional-quality results. Super soft texture feels luxurious on skin.',
'2021-03-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-shi-puff.jpg', 35,104)	
GO
insert into PRODUCT (NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'LOVE ME LIPSTICK', 'CT1','BR1',485000,'POWERFUL COLOUR, ALL-DAY MOISTURE, WEIGHTLESS SATIN-SOFT FINISH' ,
'Love at first swipe! Fall in love with an argan oil-infused formula that delivers an instant hit of powerful colour and all-day 
moisture. The True-Colour Gelled System of ultra-refined pure pigments evenly disperses bright, smooth colour for high-impact 
one-swipe payoff. A combination of lightweight oils and specialized waxes makes this lipstick feel luxurious, super-silky and 
barely there. The ultra-gliding formula lays down beautifully in a thin film for a creamy and conditioning texture. 
With a weightless feel and satin-soft finish, Love Me Lipstick loves you back.', '2021-04-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR)  
values ('lipmacbated.jpg','#7d3133',90,105)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR)  
values ('lipmacgivemefever.jpg','#b50327',30,105)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lipmacheyfrenchie.jpg','#b35867',20,105)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'SHAPE + SHADE BROW TINT', 'CT2','BR1',530000,'DUAL-ENDED PRODUCT, LIQUID/POWDER FORMULAS FOR NATURAL SHADING/SHAPING, WATERPROOF',
'This M·A·C brow tint fuses the power of a liquid brow pen and powder into a dual-ended product designed to define and set brows 
with ease. Fill brows effortlessly using the precision brush-tipped, liquid eyebrow pen liner on one end, then flip to the sponge 
on the other end to set your shape with the mess-free powder contained in the cap. Find your perfect brow shape and brow shade with 
this wax-infused powder that provides a smooth application and gently holds brows in place.', '2021-04-01')
go
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('eye-mac-spike.jpg', '#3b2c25', 45,106)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('eye-mac-stud.jpg', '#4d4341', 35,106)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'STUDIO FIX TECH CREAM-TO-POWDER FOUNDATION', 'CT3','BR1',690000,'STUDIO FIX TECH CREAM-TO-POWDER FOUNDATION',
'a lightweight, sweat- and humidity-resistant foundation in a transformative texture that provides medium buildable coverage with a natural matte finish', '2021-04-01')
go
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('STUDIO.PNG', '#e4b07e', 45,107)
GO
insert into IMAGES(NAMEIM, COLOR, DETAILQUANTITY, IDPR)
values ('pr1072.PNG', '#dea077', 35,107)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'BRUSH CLEANSER', 'CT7','BR1',690000,'a cleanser to clean and condition brush fibres so that brushes last longer.',
'a cleanser to clean and condition brush fibres so that brushes last longer.', '2021-04-01')
go
insert into IMAGES(NAMEIM, DETAILQUANTITY, IDPR)
values ('109.PNG', 45,108)
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'LIFTER GLOSS',
'CT1', 
'BR2',
250000,
'LIP GLOSS MAKEUP WITH HYALURONIC ACID',
'Meet Lifter Gloss, Maybelline NY’s new next level lip gloss. Lip gloss formula visibly smoothes lip surface and enhances lip contour with high shine for hydrated, fuller-looking lips. Formula with Hyaluronic Acid.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('110.jpg','#e5e3e1',57,109)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1102.jpg','#dc7c87',57,109)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1103.jpg','#e98b71',57,109)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'THE FALSIES LASH MASK EYELASH CONDITIONER',
'CT2', 
'BR2',
250000,
'The Falsies Lash Lift Mask conditions and cares for stressed-out lashes.',
'Calling all false lash addicts and mascara junkies! Meet Maybelline New York’s first overnight lash mask. 
Infused with Pro-Kera Complex fibers, Argan Oil and Shea Butter—you’ll have fortified lashes in the morning! 
If you have stressed-out lashes from heavy mascara usages, lash extensions and more, this lash mask is for you. 
Plus, its fluffy, flocked tip brush makes it easy to coat all lashes from roots to tips. 
Simply wear over night for more supple and soft lashes in the morning.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-maybelline-falsies-lash-maskjpg.jpg','#c4afc8',57,110)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'EXPERT WEAR',
'CT2', 
'BR2',
250000,
'EYE SHADOW',
'Expert Wear® Eyeshadow. This creamy rich eyeshadow features super saturated color that lasts up to 14 hours.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1121.jpg','#d6b4a8',57,111)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1122.jpg','#d18a77',57,111)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1123.jpg','#86708a',57,111)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'MASTER CHROMEJELLY HIGHLIGHTER FACE MAKEUP',
'CT3', 
'BR2',
235000,
'Effortlessly melt onto the skin for a buildable and reflective glow.',
'Bask your skin in the light with our new Chrome Jelly Highlighter! Create a reflective glow instantly, with one quick swipe. 
The water-based jelly formula glides onto the skin like a liquid gel and dries to a soft satin shine for a seamless finish. 
It’s infused with pearlescent pigments for an ultra-shiny and light-diffusing effect. Simply layer it for a head-turning gleam 
that wows! Available in two metallic shades – rose and bronze.','2021-04-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-maybelline-metallic-rose.jpg','#cd7966',21,112)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-maybelline-metallic-bronze.jpg','#a24c43',15,112)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'BABY SKIN®',
'CT7', 
'BR2',
235000,
'INSTANT PORE ERASER®',
'Baby Skin® Instant Pore Eraser®. This makeup primer leaves skin with a baby smooth and matte finish. Moisturizes all day.','2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('114.jpg',21,113)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'DREAM',
'CT8', 
'BR2',
200000,
'FRESH BB® CREAM',
'Dream BB Fresh has 8 skin-loving benefits in 1 lightweight formula. America’s #1 BB Cream hydrates, brightens, smoothes, and protects with broad-spectrum SPF 30. Sheer coverage gives skin a natural finish.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('115.jpg','#f2c5bf',21,114)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1152.jpg','#dca896',21,114)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Sculpting Lipstick in Exclusive James Goldcrown-Designed Case',
'CT1', 
'BR3',
890000,
'Intense lip color in shade 520 Carnal in a limited edition case by James Goldcrown.',
'The intense lip-shaping color you love, in a collectible case designed exclusively for us by James Goldcrown.

British-born artist JGoldcrown is known around the world for his instantly recognizable “Bleeding Hearts/Lovewall” murals.

Love Colorfully! Now he spreads the love for Valentine’s Day with this exclusive, limited edition collaboration. The carton and case capture JGoldcrown’s unique expression of love.

Inside, find Pure Color Envy lipstick in 520 Carnal: super creamy, sensually soft, smooth and comfortable. Glides on with saturated, lip-shaping color that sculpts, hydrates, intensifies your look.'
,'2021-04-01')
go

insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('116.JPG','rgb(182, 33, 39)',43,115)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Double Wear Zero-Smudge Lengthening Mascara',
'CT2', 
'BR3',
890000,
'Zero Smudge + Length.',
'15-hour staying power. Long lashes that last. Zero smudge.
You will love its extreme wear, extraordinary length and unstoppable power. Now the expertly separated, smudge-free lash look you see in the morning is the look you keep all day.The Smudge-Shield formula with innovative polymers locks in the mascara to keep it on lashes and off you. Resists high temperatures, high humidity and perspiration.
Micro-fiber bristles go deep into lash bed to comb and detangle lashes for super separation from root to tip. Lashes channel through the brush is saturated core for a rich coating of pigment.'
,'2021-04-01')
go

insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-estee-Lauder-Double-Wear.png','rgb(22, 22, 23)',43,116)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'RE-NUTRIV Ultra Radiance Liquid Makeup SPF 20',
'CT3', 
'BR3',
2450000,
'Look radiant: luxurious liquid foundation.',
'Release the light. Glow like a jewel with every luxurious drop of this extraordinary liquid makeup.
Captured in every bottle: the radiant power of 2 precious Peridot stones, helping boost skin’s natural energy for renewed vibrancy. Plus millions of micro-fine gems to help create a flawless, jewel-like finish.
Powerfully infused with Re-Nutriv’s advanced skincare technology, it leaves skin soft, supple and smooth. Skin looks more even. Imperfections and pores seem to disappear.With SPF 20, helps defend against UVA and UVB rays, helping maintain skin’s elasticity and density and prevent the appearance of lines and wrinkles. Reveal your skin’s infinite beauty.'
,'2021-04-01')
go

insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-1c1 cool bone.jpg','rgb(232, 206, 187)',54,117)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-1n2-ecru.jpg','rgb(233, 199, 179)',65,117)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-estee-3n1-ivory.jpg','rgb(214, 185, 157)',65,117)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Tri-Peptide Face and Neck Creme',
'CT4', 
'BR3',
2300000,
'Intense nighttime nourishment to lift and firm.',
'This rich night creme reveals a more lifted, youthful look while you sleep. Skin feels firmer, denser as elasticity increases. Lines and wrinkles look diminished. Radiance is restored.
Skin stays intensely nourished all night, so you wake up glowing with a fresh, healthy look.

Our powerful Tri-Peptide Lift Complex helps skin build its natural collagen to strengthen its natural support.

Add an energizing hydration boost by using as a weekly mask.

Pair with Resilience Lift Day as a 24-Hour lift system.'
,'2021-04-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('119.jpg',54,118)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Age Reversing Line/Wrinkle Creme',
'CT5', 
'BR3',
2300000,
'Intensive nighttime care for a younger look, fast.',
'
Help rewind the visible signs of aging at night. Look more beautiful every morning.
Delivers the intensive moisture your skin needs while you sleep.

Our revolutionary Tri-HA Cell Signaling Complex™ helps skin boost its natural production of line-plumping hyaluronic acid by 182% in just 3 days.*

A nighttime amino acid complex helps optimize skin is natural replenishment of wrinkle-smoothing collagen.'
,'2021-04-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('120.jpg',54,119)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Advanced Night Repair  Intense Reset Concentrate',

'CT6', 
'BR3',
2500000,
'Rescues and resets the look of skin fast.',
'
When you feel your skin is acting up, PRESS RESET TONIGHT.

This breakthrough overnight treatment, with Chronolux™ S.O.S. technology, rescues and resets the look of skin fast. Immerses skin in sustained, 24-hour moisture with 15X concentrated Hyaluronic Acid in a multi-molecular weight complex.

SOOTHES the look of irritation—in just 1 hour.

FORTIFIES skin so it can better respond to intense visible stressors. Allows you to power through life’s high-intensity moments beautifully.

RESTORES a more poreless, refined texture and significantly boosts skin’s luminous clarity.

Also formulated with high-powered anti-oxidants to defend against the appearance of free radical damage.

From the nighttime skincare expert. Tested on all ethnicities.'
,'2021-04-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('121.jpg',54,120)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Advanced Night Micro Cleansing Balm',
'CT7', 
'BR3',
2500000,
'Light balm melts to a cleansing oil. Removes makeup.',
'

Micro-purifying. Micro-revitalizing.
This lightweight balm melts into a silky cleansing oil as you massage over skin, then transforms with water into a milky emulsion that rinses easily for a clean, conditioned feel.

Removes makeup and impurities, including pollution, as it purifies deep within skin Is surface to improve your overall healthy look.'
,'2021-04-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('122.jpg',54,121)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Blush Brush 15',
'CT9', 
'BR3',
2500000,
'FullL rounded brush. Applies cheek color evenly.',
'This Blush Brush provides precise color application for cheeks. The fullS round shape is expertly designed to deposit color smoothly and evenly on smaller areas of the face.'
,'2021-04-01')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('123.jpg',54,122)	
GO


insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Clinique Pop™ Lacquer Lip Colour + Primer',
'CT1', 'BR4', 460000,
'A luscious pop of liquid, high-shine colour in one, full-coverage coat.',
'A luscious pop of liquid, high-shine colour in one, full-coverage coat. Luxurious yet lightweight formula with built-in primer glides on effortlessly', 
'2021-04-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('124.jpg','rgb(216, 130, 130)',40,123)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Cream Shape For Eyes','CT2', 'BR4', 460000,'Creamy-smooth pencil defines with a hint of shimmer.',
'Creamy-smooth eyeliner pencil with a hint of shimmer. Shapes and defines with intense, stay-put colour. Non-smudging, water 
and transfer-resistant. Easy to sharpen, too. Ophthalmologist tested.', '2021-04-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-clinique-black.jpg','rgb(21, 30, 44)',40,124)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-clini-hocolate_lustre.jpg','rgb(78, 47, 45)',60,124)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Stay-Matte Sheer Pressed Powder','CT3', 'BR4', 715000,'Sheer, oil-free pressed powder helps keep shine under control.', 
'Oil-free, shine-absorbing pressed powder for touch-ups anytime. Ultra-sheer texture gives skin a perfected matte appearance. 
Great for oily skin and oily spots. Maintains a fresh look and feel, even after frequent touch-ups.', '2021-04-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-clini-matte-neutral.jpg','rgb(206, 162, 136)',72,125)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-clini-matte-honey.jpg','rgb(181, 123, 95)',80,125)	
GO


insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Dramatically Different Moisturizing BB-Gel','CT5', 'BR4', 370000,'8-hour oil-free hydration naturally perfects, unifies skin tone.', 
'BB-gel with Transforming Tint Release Technology delivers 8-hour oil-free hydration and a sheer wash of color that first appears as 
a grey hue, then transforms to naturally perfect and unify skin tone. Please note this is not a universal tint for all skin tones.','2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('mois-clini-bb-gel.jpg',50,126)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Repairwear Laser Focus Smooths, Restores, Corrects','CT6', 'BR4', 1300000,'Powerhouse de-aging serum gives skin a second 
chance against lines.', 'Powerhouse de-aging serum gives skin a second chance against lines, wrinkles and sun damage. Rejuvenating 
formula smooths skin’s texture and helps plump skin so expression lines are visibly reduced.','2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('serum-clini-laser-focus.jpg', 55,127)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Extra Gentle Cleansing Foam','CT7', 'BR4', 520000,'Plush, velvety-soft foam cleanses even sensitive skins with care.', 
'Plush, velvety-soft foam cleanses even sensitive skins with care. Non-irritating formula ever-so-gently lifts dirt and impurities. 
Leaves skin feeling fresh and comfortable—never tight or dry.','2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-clini-cleansing-foam.jpg', 37,128)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values('Eye Shader Brush','CT9', 'BR4', 610000,'Large and plush. Sweeps eye shadow over entire eye surface. Also ideal for blending. ', 
'Large and plush. Essential for sweeping eye shadow over entire eye surface, lashline to brow. Also ideal for blending colour to 
complete an eye look. Unique antibacterial technology ensures the highest level of hygiene, helps keep brush irritant-free.','2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-clini-shader.jpg', 17,129)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Shimmer GelGloss','CT1', 'BR5', 600000,'A highly reflective lip gloss with transparent color. 12-hour hydration. Weightless. Non-sticky.', 
'Shine, reimagined in a highly reflective shimmer gloss with a mirror-like crystalline finish. Up to 12-hour hydration with an 
instant increase of 64% moisture, compared to not using a gloss. Enriched with shea butter to condition and nourish lips. 
Highly refractive oils and reflective pearls maximize shine. Weightless. Non-sticky. Hydrating.','2021-04-01')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-sango-peach.jpg','#f58b7a', 50,130)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('lip-shiseido-shin-ku-red.jpg','#d1202f', 30,130)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Essentialist Eye Palette',
'CT2', 'BR5', 575000,
'These silky powder eyeshadow quads lend lids pure, weightless, crease-free color that lasts 12 hours.', 
'These eyeshadow palettes are made with an innovative cream powder matrix system, which provides pure, silky color that lasts 12 hours without creasing. Soft, spherical powders create a smooth, second-skin effect, while a transparent base eliminates any chalkiness. These weightless formulas are offered in an array of finishes that range from soft mattes to shimmering metallics. Inspired by Tokyo’s iconic streets, each ultra-slim palette contains four coordinating colors that can be used to create countless eye looks. Available in 8 shade harmonies. Dermatologist and ophthalmologist-tested.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('131.jpg', 25,131)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1312.jpg', 32,131)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Refining Makeup Primer',
'CT3', 'BR5', 575000,
'Prime skin and erase imperfections for a beautiful, natural finish.', 
'Prime skin and erase imperfections for a beautiful, natural finish and improve the wear of your foundation. Fills fine lines, counteracts dullness, redness and unevenness to leave skin smooth, refined, bright and even.

Non-Comedogenic. Dermatologist-Tested.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('132.jpg', 25,132)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Pure Retinol Intensive Revitalizing Face Mask','CT4', 'BR5', 230000,'Face treatment sheet mask with moisturizing benefits to improve texture.', 
'A concentrated face treatment sheet mask that encourages skin’s natural recovery function and infuses skin with hydrating moisture 
to help improve texture. Youthful suppleness and radiance is dramatically improved with a single application.
With Pure Liquid Retinol Delivery system to help combat wrinkles, dryness, and dullness.
Relaxing fragrance inspires feelings of comfort and calm.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('mask-shi-rentinol.jpg', 90,133)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Uplifting and Firming Cream',
'CT5', 'BR5', 2789000,
'Visibly lift skin in just 1 week*, and reveal a dramatically firmer, revitalized complexion with this sculpting cream.
*Clinically tested on 35 women.', 
'Experience visibly lifted skin in just 1 week*. This scientifically advanced, silky moisturizer helps visibly offset the effects of aging in record time. Skin feels firm and sculpted with renewed fullness and bounce.
Our exclusive KURENAI-TruLift Complex and ReNeura Technology++™ strengthens skin’s natural support and improves the appearances of facial contours and definition. VP8, a blend of 5 antioxidant ingredients, provides added protection for skin. Powerful renewal for youthful-looking skin.
',
'2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('134.jpg', 25,134)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1342.jpg', 43,134)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1343.jpg', 12,134)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Ultimune Power Infusing Concentrate (Men)',
'CT6', 'BR5', 1860000,
'A hydrating men Is serum that strengthens skin Is inner defenses, delivers targeted antioxidants, and helps with damage recovery.', 
'Iconic Ultimune—reformulated for men’s unique needs.

Shiseido research has found that men’s skin differs from women’s in its ability to protect and defend itself from intrinsic and environmental aggressors.

This new serum targeted for men is skin strengthens skin’s inner defenses, delivers targeted antioxidants, and helps with damage recovery, while providing 32 hours of continous hydration*.

Shiseido Men Ultimune Power Infusing Concentrate serum delivers healthy, vibrant, energetic skin that starts from within.

Real Results:

77% of people felt Menis Ultimune boosts their skin is resistance to damage caused by external hazards (UV rays and dryness)**.
*Tested on 20 participants, aged 20–70, in France.

**Tested on 101–103 men, aged 19–70, in France.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('135.jpg', 25,135)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1352.jpg',54,135)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Quick Gentle Cleanser',
'CT7', 'BR5', 640000,
'A gentle refreshing, alcohol-free, oil-free honey-gel that foams without water to remove impurities and makeup.', 
'An alcohol-free, oil-free, honey-gel cleanser that foams without water to remove makeup while removing dirt and excess oil. Formulated with honey and royal jelly extracts, this gentle cleanser rinses off clean and nurtures skin by protecting its moisture. Skin feels soft, clean and healthy-looking to prevent the appearance of imperfections.

For dry, oily, normal, combination and sensitive skin. Dermatologist-tested. Non-comedogenic. Paraben-free. Oil-free. Alcohol-free.

Formulated with Honey Extract to nurture the skin for a healthy look.
Contains Royal Jelly Extract to deliver amino acids, vitamins and minerals to skin’s surface for added moisture.
Helps reduce the appearance of skin troubles.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('136.jpg', 25,136)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1362.jpg', 32,136)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Active Sun Protection SPF Set',
'CT8', 'BR5', 870000,
'Protect skin from UV rays during active outdoor days with this 3-piece skincare & sun protection set, including a full-sized Ultimate Sun Protector Lotion SPF 50+ Sunscreen. A $84 value.', 
'This 3-piece skincare gift set protects skin on even the most hot and humid active days. Featuring a full-sized Ultimate Sun Protector Lotion SPF 50+ sunscreen, this lightweight and clear sunscreen includes an innovative protective veil that’s strengthened by water and heat*.

Complete your skincare routine with deluxe-sized samples of ultra-hydrating Essential Energy Moisturizing Day Cream SPF 20 and skin-strengthening Ultimune Power Infusing Concentrate serum for healthy-looking, supple skin',
'2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('137.jpg', 60,137)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1372.jpg', 0,137)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1373.jpg', 0,137)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Clear Sunscreen Stick SPF 50+',
'CT8', 'BR5', 650000,
'A clear sunscreen stick with SPF 50+ that works over and under makeup for sun protection on the go.', 
'Active sunscreen on the go.<br/>
Shiseido s Clear Sunscreen Stick SPF 50+ now includes SynchroShield™ technology.
Our innovative WetForce x HeatForce technology creates an invisible, lightweight protective veil that becomes more effective in water and heat*. Delivers superior protection that goes on clear and absorbs quickly without any residue for comfortable wear.
This ocean-friendly formula offers invisible UV protection for face and body. Glide the clear stick under or over makeup for easy, portable coverage on active, outdoor days.
',
'2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('138.jpg', 60,138)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1382.jpg', 0,138)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1383.jpg', 0,138)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1384.jpg', 0,138)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values('YANE HAKE Precision Eye Brush','CT9', 'BR5', 750000,'This precise, chiseled tool is ideal for eyes and brows.', 
'The chiseled roof shape made entirely of synthetic bristles easily defines brows and fits perfectly along the lash lines.
Simply stamp powders, inks, dews, or gels across the rim of the eye to build a seamless band of pigment. Handcrafted in Japan, 
a revolutionary hidden core maintains the tool’s shape and creates the perfect balance of strength, flexibility, and control for
precise detail work.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-shi-yane.jpg', 90,139)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values('Eyelash Curler Pad','CT9', 'BR5', 150000,'An eyelash curler pad refill.', 
'Refill for Eyelash Curler.',
'2021-04-01')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('139.jpg', 90,140)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'NANAME FUDE Multi Eye Brush','CT9', 'BR5', 780000,'This versatile tool creates seamless smoky eyes, carves out your 
crease, and effortlessly blends color.', 
'Diagonally-cut, synthetic bristles suit any eye shape and can be used to define, blend, and diffuse cream, powder, and gel formulas.
These high-performing fibers provide a cushioning effect, while a revolutionary hidden core maintains the tool’s shape and creates 
the perfect balance of strength and flexibility. Handcrafted in Japan, this ultra-soft brush brilliantly deposits color and quickly 
diffuses any hard edges.',
'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-shi-naname.jpg', 40,141)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'ModernMatte Powder Lipstick','CT1', 'BR5', 650000,'A weightless, full-coverage, matte lipstick that lends lips long-lasting, velvety color.', 
'This non-drying formula delivers matte, full-coverage color that feels utterly weightless and provides a powder-soft finish on lips. A unique blend of waxes and oils melts and transforms into an ultra-thin, featherweight powder, while spherical pigments float across lips to blur imperfections. Available in 24 shades inspired by Tokyo’s vibrant nightlife, this statement-making lipstick provides eight hours of rich, velvety color. Dermatologist-tested.','')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('141.jpg','#A50034', 50,142)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1412.jpg','#E40046', 30,142)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1413.jpg','#EB3300', 30,142)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1414.jpg','#B65A65', 30,142)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1415.jpg','#e06a72', 30,142)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Crystal GelGloss','CT1', 'BR5', 650000,'This ultra-clear, hydrating gloss provides a Lucite-like finish that leaves lips looking wet and ultra shiny.', 
'This flexible, non-drying formula boasts a superior refractive index that boosts color vibrancy when worn as a top coat and creates the illusion of fuller lips. This crystalline fluid is infused with a moisturizing blend of oils for an effortless glide and high-shine polymers to lend lips an intense shine. Free of shimmer that can compromise clarity, this crystal-clear varnish is housed in a sleek tube with an integrated applicator that minimizes color contamination when the gloss is layered over pigmented products. Dermatologist-tested.',
'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('142.jpg', 50,143)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1422.jpg',0,143)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'ModernMatte Powder Lipstick Expressive Deluxe Mini Set (An $81 Value)','CT1', 'BR5', 1300000,
'An $81 value, this limited-edition wardrobe of five mini ModernMatte Powder Lipsticks comes housed in a deluxe container for the holidays.', 
'Give the gift of color and texture with these ultra-deluxe miniatures of ModernMatte Powder Lipstick in five shades that range from soft neutrals to bold berries to festive reds. This creamy, non-drying formula transforms into a weightless powder that wraps lips in velvety, matte pigment. Housed in a deluxe, giftable container for the holidays.','')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('143.jpg', 50,144)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Total Radiance Loose Powder',
'CT3', 'BR5', 1400000,
'A silky-smooth powder infused with Japanese botanical ingredients to set makeup for a sheer luminous finish and lasting wear.',
'A silky-smooth powder infused with Japanese botanical ingredients to set makeup for a sheer luminous finish and lasting wear. Includes an ultra-soft powder puff made in Japan that uses long fibers to hold the powder for the perfect application to skin.

For all skin types. Non-Comedogenic. Dermatologist-tested.

Aura Radiance Technology gives skin a radiant, resilient and smooth look.
Responds to changes in the skin for a beautiful-looking complexion over time.','')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('144.jpg', 50,145)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1442.jpg', 0,145)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1443.jpg', 0,145)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Poreless Matte Primer',
'CT3', 'BR5', 570000,
'An oil-free mattifying primer to instantly minimize the appearance of the large pores and control shine.',
'An oil-free corrective primer that blurs the look of pores and mattifies skin. Experience visible transformation in a single drop. Pat this lightweight cream over the T-zone or other oil-prone areas to minimize the appearance of large pores and shield against excess shine. Oil-absorbing powders ensure skin stays beautifully matte for hours, prolonging makeup wear. Watercress extract comforts and moisturizes the skin.

Ideal for oily and combination skin types, this primer can be used before or after foundation to control excess oil or for touch ups throughout the day.
','')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('145.jpg', 50,146)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1452.jpg', 0,146)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1453.jpg', 0,146)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1454.jpg', 0,146)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'SYNCHRO SKIN Soft Blurring Primer',
'CT3', 'BR5', 780000,
'A water-based primer that uses advanced light diffusion technology to refine the appearance of pores, erase excess shine, and blur imperfections for a soft-focus finish.',
'Make primer the first step in any makeup routine. Conceal visible pores, control oil, and blur imperfections—particularly in the T-zone—with this cream-to-powder formula. This weightless, water-based primer syncs seamlessly with all skin types and skin tones for a soft-focus finish.

Featuring light-diffusing Snowflake Powder, mattifying peptides, and Sebum Catch Powder, Synchro Skin Soft Blurring Primer absorbs oil and sweat, keeping makeup looking freshly applied all day long. A patented Natural Correcting Powder conceals unevenness and leaves complexions with a youthful radiance.
','')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('146.jpg', 50,147)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1462.jpg', 0,147)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'MicroLiner Ink',
'CT2', 'BR5', 780000,
'This micro-fine eyeliner glides across lids with the utmost precision to deliver a weightless, smudge-proof inky line that lasts up to 24 hours.',
'This foolproof eyeliner is infused with high-impact pigments that deliver smudge-proof, saturated, matte color. The weightless, inky pencil features thermo-sensory technology that allows this formula to transform from a solid to a liquid upon contact with skin, creating a flexible, water-resistant film that lasts up to 24 hours. The micro-thin lead on this next-generation pencil can be dotted between lashes or glided across eyes with remarkable precision and no skipping. Available in five shades inspired by sumi ink sticks used in traditional Japanese calligraphy. Dermatologist and ophthalmologist-tested.
','')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('147.jpg','#002B49', 50,148)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1472.jpg','#8f638b', 50,148)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1473.jpg','#101820', 50,148)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1474.jpg','#ab4b52', 50,148)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1475.jpg', 0,147)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1476.jpg', 0,148)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Full Lash and Eyebrow Serum',
'CT2', 'BR5', 780000,
'High-performance serum for elegantly long, thick-looking lashes and full brows.',
'For fuller, denser-looking lashes and brows.
A high-performance serum with sophisticated technology for elegantly long, thick-looking lashes and visibly full brows. This powerful, hydrating formula helps prevent lashes and brows from looking sparse, short and thin. Eyelashes and eyebrows appear fuller, healthier and rich with shine.
<br/>
Denser-looking lashes:<br/>

80% after 16 weeks*<br/>
65% after 8 weeks*<br/>
Fuller-looking lashes:<br/>
79% after 16 weeks*<br/>
65% after 8 weeks*<br/>
Lashes became visibly more beautiful:<br/>

84% after 16 weeks*<br/>
71% after 8 weeks*<br/>
*Based on an independent US consumer study by 100 women.<br/>

Dermatologist-Tested.','')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('148.jpg', 77,149)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1482.jpg', 0,149)	
GO





insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'TATTOOSTUDIO SMOKEY GEL PENCIL EYELINER',
'CT2', 
'BR2',
175000,
'Maybelline’s Tattoo Studio Smokey Gel Pencil is our 1st blendable gel liner.',
'Maybelline NY’s Tattoo Studio Smokey Gel Pencil glides on smooth for a sultry blend and smoldering tattoo matte finish. 
This smudge proof eyeliner doesn’t smear—even in the inner line. It’s a long lasting waterproof eyeliner that’s formulated 
with powder in a ','')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-maybelline-smokey-black.jpg','#221d1d',51,150)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-maybelline-smokey-brown.jpg','#6d4b45',50,150)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'DREAM RADIANT LIQUID HYDRATING FOUNDATION',
'CT3', 
'BR2',
300000,
'Dream Radiant Liquid Foundation visibly improves the look of skin.',
'Get ready to face the city with radiance! Experience a medium coverage foundation finish your skin will never want to take off.
This lightweight foundation, formulated with hyaluronic acid and collagen, moisturizes skin and gives a natural, radiant look. 
Delivering up to 12 hours of hydration, this new formula comes in 20 different shades and provides smooth and even-looking skin. 
It is the perfect foundation for dry skin!'
,'')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-maybelline-pure-beige.jpg','#e4bf98',21,151)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-maybelline-ivory-beige.jpg','#fcdbc5',15,151)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('face-maybelline-vanilla.jpg','#fceed9',21,151)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'FIT ME!®TINTED MOISTURIZER, NATURAL COVERAGE, FACE MAKEUP',
'CT5', 
'BR2',
230000,
'Fit Me Tinted Moisturizer face makeup. This lightweight tinted moisturizer provides a fresh feel and natural coverage with 12H hydration.
76% natural origin ingredients with aloe.',
'Maybelline Fit Me Tinted Moisturizer provides natural coverage and shine-free 12H hydration. This formula enhances skin without 
hiding it, blurs pores and conceals imperfections. It is your natural look and feel all in one easy fit created from 76% natural
origin ingredients with aloe. This natural tinted moisturizer is available in 14 hydrating shades. *We consider an ingredient to
be naturally derived if it‘s unchanged from its natural state or has undergone processing yet still retains greater than 50% of 
its molecular structure from the original natural source. The remaining ingredients constitute 24% of the formula to ensure its 
sensoriality and color cosmetic performance.'
,'')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('152.jpg','#cf9b6c',15,152)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1522.jpg','#ecc4a4',20,152)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1523.jpg','#d99d69',35,152)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'BABY LIPS®MOISTURIZING LIP BALM',
'CT5', 
'BR2',
150000,
'Baby Lips® Moisturizing Balm moisturizes lips for a full eight hours. Lips are visibly renewed after one week.',
'It’s clinical care for baby soft lips. Exclusive formula moisturizes and protects lips for a full eight hours.
After one week, lips are visibly renewed.</br>
88% experienced more smooth lips</br>
83% experienced better-looking lips</br>
82% experienced less dry lips</br>
70% experienced more supple lips'
,'')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('153.jpg','#a12d53',25,153)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1532.jpg','#de5da4',20,153)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'LASH SENSATIONAL® BOOSTING EYELASH SERUM',
'CT6', 
'BR2',
290000,
'A sensational eyelash serum for thicker and fuller looking lashes in just 4 weeks*.  Achieve more plush, beautiful looking 
lashes that are soft, supple, and strong.',
'Fortify and condition lashes with our 1st eyelash serum. Overtime, lashes will seem thicker and fuller, with less fallout during
makeup removal. Healthier more beautiful looking lashes in just 4 weeks*.'
,'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('154.jpg',20,154)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1542.jpg',0,154)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'FACESTUDIO® POWDER BRUSH',
'CT9', 
'BR2',
240000,
'Facestudio® Brushes are designed to fit the angles of the face to create a flawless finish. The satin-soft fibers help to retain
the shape without splaying or fraying.',
'"It’s easy to create pro looks anywhere with our curved brush collection. Discover the range: Foundation Brush, Powder Brush, 
Concealer Brush, Contour Brush, and Shadow Brush. "'
,'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('155.jpg',10,155)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1552.jpg',0,155)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'EXPERT TOOLS®BRUSH & COMB',
'CT9', 
'BR2',
110000,
'Expert Tools® Brush & Comb makeup tool shapes, grooms, and arches eyebrows and separates eyelashes.',
'This 100% natural fiber brush shapes and grooms brows, while the comb separates lashes and eliminates mascara clumps.'
,'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('156.jpg',10,156)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1562.jpg',0,156)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'EYESTUDIO® BROW PRECISE® SHAPING PENCIL',
'CT2', 
'BR2',
170000,
'Eyestudio® Brow Precise® shaping pencil and grooming brush delivers impeccable precision.',
'This natural wax pencil creates fine, hair-like strokes while the grooming brush blends and softens for a natural finish.'
,'')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('157.jpg','#422f2a',17,157)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('1572.jpg','#824d34',20,157)	
GO



insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 
'Eyeliner/Brow Brush 20',
'CT9', 
'BR3',
980000,
'Precision-angled brush to shape brows, line eyes.',
'Line and define with precision. This brush is angled tip makes applying brow powder and liquid or gel eyeliner a breeze.
This brush can also be used to line eyes with powder eyeshadow. Press brush tip into eyeshadow, then press into lashline.
Continue lining for desired effect: thin or thick, straight or smudged.','')
go

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-estee-eyeline-brush.jpg',80,158)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values(
'Powder Foundation Brush',
'CT9', 
'BR3',
1230000,
'Large, full brush. A must for any powder foundation.',
'Now it is easy to buff to perfection.
This large, full brush is essential for any loose or pressed powder foundation. Engineered to provide fuller coverage and a 
more polished look than the Powder Brush.','')
go


insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-estee-powder-brush.jpg',80,159)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'All About Shadow Octet','CT2', 'BR4', 966000,'Versatile eye shadow palettes are perfect for day and amped up for night',
'Versatile eye shadow palettes are perfect for day…amped up for night when you layer multiple shades for extra depth and dimension.
Long-wearing shades are crease- and fade-resistant. Ophthalmologist tested, too.', '')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('eye-clini-octet.jpg',65,160)	
GO

insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-estee-powder-brush.jpg',80,160)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'All About Shadow Octet','CT2', 'BR4', 966000,'Versatile eye shadow palettes are perfect for day and amped up for night',
'Versatile eye shadow palettes are perfect for day…amped up for night when you layer multiple shades for extra depth and dimension.
Long-wearing shades are crease- and fade-resistant. Ophthalmologist tested, too.', '')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('eye-clini-octet.jpg',65,161)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Chubby Stick Shadow Tint For Eyes','CT2', 'BR4', 425000,' A brilliant range of mistake-proof shades to mix and layer',
'Sheer wash of lightweight, creamy colour slips on. Layerable and long-wearing. Versatile, too. Glide one on for a swift wash of 
colour. Contour with another to add depth, and yet another to highlight. There is no need to stop at just one. Appropriate for 
sensitive eyes and contact lens-wearers.', '')
go
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-clini-latte.jpg','rgb(140, 111, 98)',50,162)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eye-clini-lavis.jpg','rgb(161, 139, 170)',42,162)	
GO
insert into IMAGES(NAMEIM,COLOR,DETAILQUANTITY,IDPR) 
values ('eyes-clini-fuller-fudge.jpg','rgb(113, 74, 58)',48,162)	
GO


insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Moisture Surge Hydrating Supercharged Concentrate','CT5', 'BR4', 945000,'Antioxidant-infused water-gel gives skin an intense moisture boost.', 
'Supercharged water-gel hydrator instantly quenches dehydrated skin with a moisture boost. Keeps skin hydrated for a full 72 hours.
Helps break the cycle of dryness and environmental stress that can lead to premature aging.','')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('moisture-clini-surge-hydrating.jpg',45,163)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1612.JPG',0,163)	
GO


insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Acne Solutions Cleansing Foam','CT7', 'BR4', 520000,'Cleansing foam powered by 2% salicylic acid helps clear and prevent acne, and unclog pores.', 
'Cleansing foam powered by 2% salicylic acid helps clear and prevent acne, and unclog pores.
Daily medicated cleanser with 2% salicylic acid removes dirt and excess oil. Helps keep pores clear for healthier-looking skin. 
Salicylic acid and acetyl glucosamine: Help clear dead skin cells that can contribute to clogged pores.
Laminaria saccharina extract: Helps prevent oil buildup that can lead to breakouts.','')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('cleanser-clini-acne-solution.jpg', 35,164)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'Sports BB Cream SPF 50+ Sunscreen','CT8', 'BR5', 770000,'Multi-functional BB cream with sunscreen for medium coverage and excellent blendability.', 
'A quick-dry BB protector for non-sticky, longer-lasting beauty. It rapidly dries sweat to prevent makeup from running, while 
reacting with water to improve UV protection. Helps give skin a natural, healthy, contoured look for a beautiful finish that lasts 
in the sun all day.',
'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('sunsreen-shi-sport-bbcream.jpg', 68,165)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'UV Protective Compact Foundation SPF 36','CT8', 'BR5', 680000,'A travel-friendly SPF compact foundation that delivers a powdery finish. 
Broad Spectrum SPF 36', 
'Resistant to water and sebum, they provide a long lasting, natural-looking finish, while safeguarding skin’s beauty for the future.
Exclusive SuperVeil-UV 360TM technology and ProfenseCELTM to resist aging, Shiseido sun foundations protect skin from damage caused
by external aggressors such as UV rays and dryness. Case sold separately.',
'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('suncreen-shi-uv-compact.jpg',57,166)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1642.jpg', 0,166)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'DAIYA FUDE Face Duo','CT9', 'BR5', 890000,'This double-ended tool features a gel tip that mimics the effect of fingertips,
while the red, diamond-cut brush was built for blending.', 
'A gel tip blender on one side of this tool mimics the effect of fingertips without absorbing product like a traditional sponge. 
Hygienic and easy to wipe clean, this applicator adapts to the contours of the face to build optimal coverage. The red, 
diamond-shaped synthetic brush head looks and feels fluffy but contains a large amount of dense fibers at its core to maintain 
the tool’s shape and provide the perfect balance of strength and flexibility. This ergonomic brush is compatible with creams, 
powders, liquids, and gels. Each intricate brush is hand-crafted in Japan by a team of seasoned artisans.',
'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-shi-daiya.jpg', 100,167)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1652.jpg', 0,167)	
GO
insert into PRODUCT (NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'HANATSUBAKI HAKE Polishing Face Brush','CT9', 'BR5', 1100000,'Four-petal face brush that is uniquely designed to contour
to face and buff skin to a polished finish.', 
'Inspired by the SHISEIDO camellia flower (“hanatsubaki” in Japanese), this uniquely designed brush features four distinct petal 
sections that contour the face to maintain optimal skin contact while buffing skin into a smooth and polished finish.
With Hidden Core technology, this brush controls pressure on application for a seamless makeup finish. Covetable and artistic design. Portable. Luxuriously soft.',
'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-shi-hake.jpg', 115,168)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1662.jpg', 0,168)	
GO

insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values( 'NANAME FUDE Multi Eye Brush','CT9', 'BR5', 780000,'This versatile tool creates seamless smoky eyes, carves out your 
crease, and effortlessly blends color.', 
'Diagonally-cut, synthetic bristles suit any eye shape and can be used to define, blend, and diffuse cream, powder, and gel formulas.
These high-performing fibers provide a cushioning effect, while a revolutionary hidden core maintains the tool’s shape and creates 
the perfect balance of strength and flexibility. Handcrafted in Japan, this ultra-soft brush brilliantly deposits color and quickly 
diffuses any hard edges.',
'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-shi-naname.jpg', 40,169)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('1672.jpg', 0,169)	
GO
insert into PRODUCT ( NAMEPR, IDCTGR, IDBR, PRICE, BRIEFSUM, DESCRIPTION, CREATEDATE) 
values('YANE HAKE Precision Eye Brush','CT9', 'BR5', 750000,'This precise, chiseled tool is ideal for eyes and brows.', 
'The chiseled roof shape made entirely of synthetic bristles easily defines brows and fits perfectly along the lash lines.
Simply stamp powders, inks, dews, or gels across the rim of the eye to build a seamless band of pigment. Handcrafted in Japan, 
a revolutionary hidden core maintains the tool’s shape and creates the perfect balance of strength, flexibility, and control for
precise detail work.',
'')
go
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('access-shi-yane.jpg', 90,170)	
GO
insert into IMAGES(NAMEIM,DETAILQUANTITY,IDPR) 
values ('168.jpg', 0,170)	
GO



update PRODUCT set STATUSPRO =1  WHERE STATUSPRO is null
go
update BRAND set STTBRAND =1  WHERE STTBRAND is null
go
update CATEGORY set STTCT =1  WHERE STTCT is null
go
update USERS set STTUSER =1  WHERE STTUSER is null
go

