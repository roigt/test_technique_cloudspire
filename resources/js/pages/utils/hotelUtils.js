
//récupérer la première image d'un hotel selon sa position
export const getMainImage=(hotel) =>{
        if(!hotel || !hotel.pictures || hotel.pictures.length===0) return "null";

        return hotel.pictures.reduce((min, current) => {
            return current.position < min.position ? current : min;
        });
};


export async function verifIfImageExists(filepath){
     try{
         const response = await fetch(`http://localhost:8000/storage/${filepath}`);
         return response.ok;
     }catch{
         return false;
     }
}
