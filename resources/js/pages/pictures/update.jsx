import HotelPictureForm from '@/pages/components/hotelPictureForm.jsx';
import axios from 'axios';


export default function Update({hotelId,pictureId,image}) {

    const handleSubmit=async (formData)=>{
        await axios.post(`/api/hotels/${hotelId}/pictures/${pictureId}`, formData, {
            headers:{ 'Content-Type': 'multipart/form-data' }
        });
    }

    const old_values={
        image: image.filepath,
        position:image.position,
    }
    return <HotelPictureForm title="Modifier Image de l'hôtel" onSubmit={handleSubmit} initialValues={old_values} />
}
