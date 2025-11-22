import { Box, Button, Center, FormControl, FormErrorMessage, FormLabel, Input, Text, Toast, useToast } from '@chakra-ui/react';
import { Field, Form, Formik } from 'formik';
import { router } from '@inertiajs/react';


export default function HotelPictureForm({title,initialValues,onSubmit,nextPos}) {

    //notification avec chakra ui
    const toast = useToast();

    const defaultValues = {
        image:null,
        position:nextPos
    }

    const handleSubmit =async (values,actions) => {
        const {setSubmitting, setErrors}=actions;
        try{
            const formData = new FormData();
            formData.append('image', values.image);
            formData.append('position', nextPos);
            const response = await onSubmit(formData);


            toast({
                title:`Photo Créer avec succès!!`,
                status:"success",
                position:'top-right',
                duration:3000,
                isClosable:true
            })
        }catch(error){
            if(error.response.status === 422){
                setErrors(error.response.data.errors);
                toast({
                    title:'Veuillez remplir convenablement les champs requis',
                    status: 'error',
                    position: 'top-right',
                    duration:3000,
                    isClosable:true
                })
            }else{
                toast({
                    title:"Erreur lors de l envoi de la photo",
                    status: 'error',
                    position: 'top-right',
                    duration:3000,
                    isClosable:true
                })
            }
        }finally {
            setSubmitting(false);
        }

    };

    return (
        <Center p={10}>
            <Box p={10} w="50%" bg="blue.300" backgroundColor={'whitesmoke'}  borderRadius={35} boxShadow='2xl'>
                <Center mb={5}>
                    <Text
                        bgGradient='linear(to-l, #7928CA, #FF0080)'
                        bgClip='text'
                        fontSize='3xl'
                        fontWeight='bold'
                    >
                        {title}
                    </Text>
                </Center>

                <Formik initialValues={initialValues||defaultValues} onSubmit={handleSubmit}>

                    {({ setFieldValue, isSubmitting }) => (
                        <Form>

                            {/* Image */}
                            <Field name="image">
                                {({ form }) => (
                                    <FormControl
                                        isInvalid={form.errors.image && form.touched.image}
                                        mb={4}
                                    >
                                        <FormLabel>Choisir une image</FormLabel>
                                        <Input
                                            backgroundColor={'purple.50'}
                                            borderRadius={25}
                                            type="file"
                                            accept="image/*"
                                            onChange={(event) =>
                                                setFieldValue("image", event.target.files[0])
                                            }
                                        />
                                        <FormErrorMessage>{form.errors.image}</FormErrorMessage>
                                    </FormControl>
                                )}
                            </Field>

                            <Button
                                colorScheme="red"
                                borderRadius={20}
                                m={5}
                                isLoading={isSubmitting}
                                onClick={() => router.visit(`/hotels/`)}
                            >
                                Annuler
                            </Button>
                            <Button
                                colorScheme="purple"
                                borderRadius={20}
                                isLoading={isSubmitting}
                                type="submit"
                            >
                                Envoyer
                            </Button>

                        </Form>
                    )}
                </Formik>
            </Box>
        </Center>
    )

}
