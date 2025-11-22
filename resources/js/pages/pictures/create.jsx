import HotelPictureForm from '@/pages/components/hotelPictureForm.jsx';
import axios from 'axios';


export default function Create({hotelId,nextPosition}) {

    const handleSubmit=async (formData)=>{
        await axios.post(`/api/hotels/${hotelId}/pictures/`, formData, {
            headers:{ 'Content-Type': 'multipart/form-data' }
        });
    }
    console.log(nextPosition)

    return (
        <HotelPictureForm
            onSubmit={handleSubmit}
            title="Ajouter une image à l'hôtel"
            nextPos={nextPosition}
        />
    )
}
