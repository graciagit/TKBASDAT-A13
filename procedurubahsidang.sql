CREATE OR REPLACE FUNCTION UBAH_SIAP_SIDANG() 
RETURNS trigger AS 
$$ 
BEGIN 
	IF NEW.pengumpulanhardcopy='TRUE' AND NEW.izinmajusidang='TRUE' THEN
		NEW.issiapsidang='TRUE';
	END IF;
RETURN NEW; 
END 
$$ 
LANGUAGE plpgsql; 