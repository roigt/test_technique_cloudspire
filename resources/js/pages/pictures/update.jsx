import HotelPictureForm from '@/pages/components/hotelPictureForm.jsx';
import axios from 'axios';
import { Box } from '@chakra-ui/react';
import Header from '@/pages/components/header.jsx';

export default function Update({hotelId,pictureId,image}) {

    const handleSubmit=async (formData)=>{
        return await axios.post(`/api/hotels/${hotelId}/pictures/${pictureId}`, formData, {
            headers:{ 'Content-Type': 'multipart/form-data' }
        });
    }

    const old_values={
        image: image.filepath,
        position:image.position,
    }
    console.log(old_values);
    return <Box>
                <Header
                    showSearch={false}
                />
                <HotelPictureForm title="Modifier Image de l'hôtel" onSubmit={handleSubmit} initialValues={old_values}  />
           </Box>

}
