<?PHP
class ProduitC {
function afficherProduit ($produit){
		echo "Id: ".$produit->getId()."<br>";
		echo "Libelle: ".$produit->getLib()."<br>";
		echo "Prix: ".$produit->getPrix()."<br>";
		echo "Image: ".$produit->getImage()."<br>";
		echo "Description: ".$produit->getDescription()."<br>";
        echo "qte_prod: ".$produit->getQte()."<br>";
	}
	
	function ajouterProduit($produit){
		$sql="insert into produit (lib_prod,prix,image,description,qte_prod,id) values (:lib_prod,:prix,:image,:description,:qte_prod,:id)";
		$db = config::getConnexion();
		try{
        $req=$db->prepare($sql);
		
       
        $lib_prod=$produit->getLib();
        $prix=$produit->getPrix();
        $image=$produit->getImage();
        $description=$produit->getDescription();
        $qte_prod=$produit->getQte();
        $id=$produit->getIdC();
  
		
		$req->bindValue(':lib_prod',$lib_prod);
		$req->bindValue(':prix',$prix);
		$req->bindValue(':image',$image);
		$req->bindValue(':description',$description);
        $req->bindValue(':qte_prod',$qte_prod);
        $req->bindValue(':id',$id);
        
		
            $req->execute();
           
        }
        catch (Exception $e){
            echo 'Erreur: '.$e->getMessage();
        }
		
	}
	
	function afficherProduits(){
		$sql="SELECT categories.leb_cat,produit.idp,produit.lib_prod,produit.prix,produit.image,produit.description,produit.qte_prod FROM produit,categories WHERE produit.id=categories.id_cat";
		$db = config::getConnexion();
		try{
		$liste=$db->query($sql);
		return $liste;
		}
        catch (Exception $e){
            die('Erreur: '.$e->getMessage());
        }	
	}
    function supprimerProduit($idp){
		$sql="UPDATE produit SET etat='1' where idp= :idp";
		$db = config::getConnexion();
        $req=$db->prepare($sql);
		$req->bindValue(':idp',$idp);
		try{
            $req->execute();
           // header('Location: index.php');
        }
        catch (Exception $e){
            die('Erreur: '.$e->getMessage());
        }
	}
	function modifierProduit($produit,$idp){
		$sql="UPDATE produit SET  lib_prod=:lib_prod,prix=:prix,image=:image,description=:description,qte_prod=:qte_prod,id=:id WHERE idp=:idp";
		
		$db = config::getConnexion();
try{		
        $req=$db->prepare($sql);
		
        $lib_prod=$produit->getLib();
        $prix=$produit->getPrix();
        $image=$produit->getImage();
        $description=$produit->getDescription();
        $qte_prod=$produit->getQte();
        $id=$produit->getIdC();
		$datas = array( ':idp'=>$idp, ':lib_prod'=>$lib_prod,':prix'=>$prix,':image'=>$image,':description'=>$description,':qte_prod'=>$qte_prod,':id'=>$id);
		
		$req->bindValue(':idp',$idp);
		$req->bindValue(':lib_prod',$lib_prod);
		$req->bindValue(':prix',$prix);
		$req->bindValue(':image',$image);
		$req->bindValue(':description',$description);
        $req->bindValue(':qte_prod',$qte_prod);
        $req->bindValue(':id',$id);
		
		
            $s=$req->execute();
			
           // header('Location: index.php');
        }
        catch (Exception $e){
            echo " Erreur ! ".$e->getMessage();
   echo " Les datas : " ;
  print_r($datas);
        }
		
	}
	function recupererProduit($idp){
		$sql="SELECT * from produit where idp=$idp";
		$db = config::getConnexion();
		try{
		$liste=$db->query($sql);
		return $liste;
		}
        catch (Exception $e){
            die('Erreur: '.$e->getMessage());
        }
	}
    function afficherProduitsEssai(){
		$sql="SELECT * from produit";
		$db = config::getConnexion();
		try{
		$liste=$db->query($sql);
		return $liste;
		}
        catch (Exception $e){
            die('Erreur: '.$e->getMessage());
        }	
	}
	 function afficherCat()
    {
        $sql="SELECT * from categories ";
        $db = config::getConnexion();
        try{
        $liste=$db->query($sql);
        return $liste;
        }
        catch (Exception $e){
            die('Erreur: '.$e->getMessage());
        }
    }
}


?>