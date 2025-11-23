import { useEffect, useRef, useState } from 'react';
import {
    AlertDialog,
    AlertDialogBody,
    AlertDialogContent,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogOverlay,
    Box,
    Button,
    Center,
    Image,
    Text,
    useDisclosure,
    useToast,
} from '@chakra-ui/react';
import { Reorder, useDragControls } from "framer-motion";
import { DeleteIcon, DragHandleIcon } from '@chakra-ui/icons';
import axios from 'axios';

export default function Index({ pictures: initialPictures, hotelId }) {
    const [pictures, setPictures] = useState(initialPictures);
    const [saving, setSaving] = useState(false);
    const toast = useToast();

    //toast bouton suppression d'hotel
    const { isOpen, onOpen, onClose } = useDisclosure()
    const cancelRef = useRef();
    const [selectedHotel,setSelectedHotel]=useState(null)
    const [selectedImage, setSelectedImage]=useState(null)


    const handleReorder = async (newOrder) => {

        setPictures(newOrder);


        const updatedPositions = newOrder.map((picture, index) => ({
            id: picture.id,
            position: index + 1,
        }));


        try {
            setSaving(true);

            await axios.patch(`http://localhost:8000/api/hotels/${hotelId}/pictures/reorder`, {
                pictures: updatedPositions
            });

            toast({
                title: 'Ordre mis à jour avec succès!!',
                description: 'Les positions des images ont été sauvegardées',
                status: 'success',
                duration: 3000,
                position: 'top-right',
                isClosable: true,
            });

        } catch (error) {

            setPictures(initialPictures);

            toast({
                title: `erreur`,
                description: 'Impossible de sauvegarder les positions',
                status: 'error',
                duration: 3000,
                position: 'top-right',
                isClosable: true,
            });
        } finally {
            setSaving(false);
        }
    };

    //gestion de la suppression d'un hôtel côté front
    useEffect(() => {

    },[pictures]);
    const deleteImage = async (hotelId,imageId)=> {
        try{

            setPictures(prevPictures=>prevPictures.filter(picture=>picture.id !==imageId));

            const response=await axios.delete(`http://localhost:8000/api/hotels/${hotelId}/pictures/${imageId}`);

            /* toast de confirmation de suppression*/
            toast({
                title: 'Image supprimé avec succès!!',
                status: 'success',
                position:'top-right',
                isClosable: true,
            })
          //  fetchHotels(page)

        }catch(error){

            toast({
                title:`Erreur lors de la suppression de l'hôtel`,
                status: 'error',
                position:'top-right',
                isClosable: true,
            })
        }
    }


    return (
        <Box p={4}>
            <Center>
                <Text
                      fontSize="xl"
                      fontWeight="bold"
                      mb={4}>
                    Glisser déposer pour ordonner les images
                </Text>
            </Center>

            <Reorder.Group
                axis="y"
                values={pictures}
                onReorder={handleReorder}
            >
                {pictures.map((picture, index) => (
                    <PictureItem
                        key={picture.id}
                        picture={picture}
                        index={index}
                        saving={saving}
                        deleteImage={deleteImage}
                        onOpen={onOpen}
                        hotelId={hotelId}
                        setSelectedHotel={setSelectedHotel}
                        setSelectedImage={setSelectedImage}
                    />

                ))}
            </Reorder.Group>
            {/* Boite de dialogue de confirmation de suppression d un hôtel */}
            <AlertDialog isOpen={isOpen} leastDestructiveRef={cancelRef} onClose={onClose}>
                <AlertDialogOverlay>
                    <AlertDialogContent>
                        <AlertDialogHeader fontSize="lg" fontWeight="bold">
                            Supprimer l'hôtel
                        </AlertDialogHeader>

                        <AlertDialogBody>Voulez-vous vraiment supprimer cet hôtel??</AlertDialogBody>

                        <AlertDialogFooter>
                            <Button ref={cancelRef} onClick={onClose}>
                                Cancel
                            </Button>
                            <Button
                                colorScheme="red"
                                ml={3}
                                onClick={() => {
                                    deleteImage(selectedHotel,selectedImage);
                                    onClose();
                                }}
                            >
                                Delete
                            </Button>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialogOverlay>
            </AlertDialog>
            {/* fin boite de dialogue de suppression d'hotel*/}
        </Box>
    );
}


function PictureItem({ picture, index, saving,onOpen,setSelectedHotel,setSelectedImage,hotelId }) {
    const controls = useDragControls();

    return (
        <Reorder.Item
            value={picture}
            dragListener={false}
            dragControls={controls}
            style={{ listStyle: 'none' }}
        >
           <Center>
               <Box
                   width="50%"
                   bg="whitesmoke"
                   borderRadius="lg"
                   p={3}
                   mb={2}
                   shadow="xl"
                   display="flex"
                   alignItems="center"
                   gap={3}
                   cursor={saving ? 'wait' : 'grab'}
                   opacity={saving ? 0.6 : 1}
                   _hover={{ shadow: 'lg' }}
                   onPointerDown={(e) => controls.start(e)}
               >
                   {/* gestion du drag an drop*/}
                   <DragHandleIcon boxSize={6} color="gray.400" />

                   {/* Box affichage de l image */}
                   <Image
                       borderRadius="2xl"
                       boxSize="80px"
                       objectFit="cover"
                       src={`http://localhost:8000/storage/${picture.filepath}`}
                       alt={`Position ${index + 1}`}
                   />

                   {/* Information box */}
                   <Box flex={1}>
                       <Text fontWeight="bold">Position : {index + 1} </Text>
                       <Text fontSize="sm" color="gray.500">
                           ID: {picture.id}
                       </Text>
                   </Box>
                   <Button
                       w="100px"
                       colorScheme="red"
                       onClick={() => {
                           setSelectedHotel(hotelId);
                           setSelectedImage(picture.id)
                           onOpen();
                       }}
                   >
                       <DeleteIcon mr={1}/>
                       Supprimer
                   </Button>
                   {/* message d'attente de sauvegarde*/}
                   {saving && (
                       <Text fontSize="xs" color="blue.500" fontWeight="bold">
                           Sauvegarde...
                       </Text>
                   )}
               </Box>
           </Center>


        </Reorder.Item>
    );
}
